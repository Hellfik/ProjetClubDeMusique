<?php 

namespace App\Listener;

use App\Entity\Musiciens;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber {

    public function __construct(CacheManager $cacheManager, UploaderHelper $helper){
        $this->cacheManager = $cacheManager;
        $this->UploaderHelper  = $helper;

    }

    public function getSubscribedEvents(){
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if(!$entity instanceof Musiciens && !$entity instanceof Article){
            return;
        }

          $this->cacheManager->remove($this->UploaderHelper->asset($entity, 'imageFile'));
        
    }

    public function preUpdate(PreUpdateEventArgs $args){
        $entity = $args->getEntity();
        if(!$entity instanceof Musiciens && !$entity instanceof Article){
            return;
        }

        if($entity->getImageFile() instanceof UploadedFile){
            $this->cacheManager->remove($this->UploaderHelper->asset($entity, 'imageFile'));
        }
    }
}