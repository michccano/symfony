<?php 
namespace App\Entity; 


use Symfony\Component\Validator\Constraints as Assert;  class User { 
   /** 
      * @Assert\NotBlank() 
   */ 
   private $name;  
      
   /** 
      * @Assert\NotBlank() 
   */ 
   private $age;  
      
   /** 
      * @Assert\NotBlank(message="Please, upload the photo.") 
      * @Assert\File(mimeTypes={ "image/png", "image/jpeg" }) 
   */ 
   private $photo; 
      
   public function getName() { 
      return $this->name; 
   } 
   public function setName($name) { 
      $this->name = $name; 
      return $this; 
   } 
   public function getAge() { 
      return $this->age; 
   } 
   public function setAge($age) { 
      $this->age = $age; 
      return $this; 
   } 
   public function getPhoto() { 
      return $this->photo; 
   } 
   public function setPhoto($photo) { 
      $this->photo = $photo; 
      return $this; 
   } 
} 