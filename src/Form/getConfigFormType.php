<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;

Class getConfigFormType extends AbstractType {
    
    /**
     * permet de configurer mes options pour mon rendu du form
     *
     * @param [type] $label
     * @param [type] $placeholder
     * @param array $options
     * @return array
     */
    public function getConfig($label,$placeholder,$options=[]){  

     return array_merge_recursive([
        'label' => $label,
        'attr'  => ['placeholder' => $placeholder
        ]
    
    ],$options);
    }

}

