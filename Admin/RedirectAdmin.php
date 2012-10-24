<?php
namespace MFB\RedirectBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Form\FormMapper,
    Sonata\AdminBundle\Datagrid\ListMapper;

use MFB\RedirectBundle\Entity\Redirect;

use MFB\RedirectBundle\Entity\Types\RedirectStatusType;

use MFB\RedirectBundle\Service\RedirectService;

/**
 * block admin
 */
class RedirectAdmin extends Admin
{
    /**
     * The label class name  (used in the title/breadcrumb ...)
     *
     * @var string
     */
    protected $classnameLabel = 'redirect';

    /**
     * The base route pattern used to generate the routing information
     *
     * @var string
     */
    protected $baseRoutePattern = '/redirects';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('slug')
            ->add('target')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                )
            )
        );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('slug', null, array('required' => true))
            ->add('target', null, array('required' => true))
            ->add('status', 'choice', array(
                'label' => 'Status',
                'choices' => RedirectStatusType::getChoices(),
                'required'  => true,
            ))
            ->end();
    }

    /**
     * Clear cache after saving
     *
     * @param Redirect $object
     *
     * @return void
     */
    public function postUpdate($object)
    {
        $this->getRedirectService()->clearCache($object->getSlug());
    }

    /**
     * Clear cache after saving
     *
     * @param Redirect $object
     *
     * @return void
     */
    public function postRemove($object)
    {
        $this->getRedirectService()->clearCache($object->getSlug());
    }

    /**
     * @return RedirectService
     */
    protected function getRedirectService()
    {
        return $this->get('mfb_redirect.service.redirect');
    }

    /**
     * Gets a service.
     *
     * @param string $id The service identifier
     *
     * @return object The associated service
     */
    protected function get($id)
    {
        return $this->configurationPool->getContainer()->get($id);
    }
}