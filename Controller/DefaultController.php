<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\CmsBundle\Controller;

use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vince\Bundle\CmsBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{

    /**
     * Display feed with all published Articles ordered by start publication date
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     * @return Response
     */
    public function feedAction()
    {
        $format = $this->getRequest()->getRequestFormat() == 'xml' ? 'rss' : $this->getRequest()->getRequestFormat();
        $articles = $this->get('doctrine.orm.entity_manager')->getRepository('VinceCmsBundle:Article')->findAllPublishedOrdered();

        return $this->render(sprintf('VinceCmsBundle:Templates:feed.%s.twig', $format), array(
            'articles' => $articles,
            'id'       => sha1($this->get('router')->generate('cms_feed', array('_format' => $format), true))
        ));
    }

    /**
     * Show an article
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     * @return JsonResponse|RedirectResponse|Response
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     * @throws \InvalidArgumentException
     */
    public function showAction()
    {
        // Retrieve article from its id in Request attributes
        $article = $this->getDoctrine()->getRepository('VinceCmsBundle:Article')->findOneByIdJoinTemplate($this->getRequest()->attributes->get('_id'));
        if (!$article) {
            throw $this->createNotFoundException();
        } elseif (!$article->isPublished() && !$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $options = array('article' => $article);

        // Form has been sent to the article
        if ($this->getRequest()->isMethod('post')) {
            $parameters = array_keys($this->getRequest()->request->all());
            if (!$this->get('vince.processor.chain')->has($parameters[0])) {
                throw new \InvalidArgumentException(sprintf('You must implement a vince.processor tagged service for form %s.', $parameters[0]));
            } else {
                $return = $this->get('vince.processor.chain')->get($parameters[0])->process($this->getRequest());
                // Processor returns a Response object
                if (is_object($return) && $return instanceof Response) {
                    return $return;
                // Processor returns Form object containing errors
                } elseif (is_object($return) && $return instanceof Form) {
                    $options['form'] = $return->createView();
                // Processor returns true, but Request is ajax
                } elseif ($this->getRequest()->isXmlHttpRequest()) {
                    return new JsonResponse(array('message' => $this->get('translator')->trans('message.contact.success', array(), 'cms')));
                // Processor returns true, Request is not ajax
                } else {
                    $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('message.contact.success', array(), 'cms'));

                    return $this->redirect($this->generateUrl($article->getRouteName()));
                }
            }

            // Processor finished, Form has errors and Request is ajax
            if ($this->getRequest()->isXmlHttpRequest()) {
                return new Response($this->get('jms_serializer')->serialize(array_merge(array(
                    'message' => $this->get('translator')->trans('message.form.invalid', array(), 'cms')
                ), $options), 'json'), 400);
            }
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('message.form.invalid', array(), 'cms'));

            return $this->render($article->getTemplate()->getPath(), $options)->setStatusCode(400);
        }

        return $this->render($article->getTemplate()->getPath(), $options);
    }

    /**
     * Display contact form
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param FormView $form Form view
     *
     * @return Response
     */
    public function contactAction($form = null)
    {
        if (!$form) {
            $form = $this->createForm(new ContactType());
            $form = $form->createView();
        }

        return $this->render('VinceCmsBundle:Component:contact.html.twig', array('form' => $form));
    }
}
