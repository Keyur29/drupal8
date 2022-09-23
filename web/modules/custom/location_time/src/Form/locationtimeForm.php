<?php

namespace Drupal\location_time\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class locationtimeForm extends ConfigFormBase {

	/**  
   	* {@inheritdoc}  
   	*/  
  	protected function getEditableConfigNames() {  
	    return [  
	      'locationtime.adminsettings',  
	    ];  
  	}  

  	/**  
   	* {@inheritdoc}  
   	*/  
  	public function getFormId() {  
    	return 'locationtime_form';  
  	}

  	/**  
   	* {@inheritdoc}  
   	*/  
  	public function buildForm(array $form, FormStateInterface $form_state) {  
	    $config = $this->config('locationtime.adminsettings');
	  
	    $form['country'] = [
	      '#type' => 'textfield',
	      '#title' => $this->t('Country'),
	      '#default_value' => $config->get('country'),
	    ];

	    $form['city'] = [
	      '#type' => 'textfield',
	      '#title' => $this->t('City'),
	      '#default_value' => $config->get('city'),
	    ];

	  	/**  
	   	*   timezone_options field is created for dynamic options purpose only
	   	*/ 
	    $form['timezone_options'] = [
	      '#type' => 'textfield',
	      '#title' => $this->t('Timezone Options'),
	      '#description' => $this->t('Put comma separated vaulues like America/Chicago,America/New_York etc'),
	      '#default_value' => $config->get('timezone_options'),
	    ];

	    $tzopt = $config->get('timezone_options');
	    $tzoptions = explode(",", $tzopt);

	    $opt = [];
	    foreach($tzoptions as $key => $val){
	      $opt[$val] = $val;
	    }
	    
	    $form['timezone'] = array(
  	      '#type' => 'select',
  		  '#title' => t('Timezone'),
  		  '#options' => $opt,
  		  '#default_value' => $config->get('timezone'),
		);
	  
	    return parent::buildForm($form, $form_state);
  	}

  	/**  
   	* {@inheritdoc}  
   	*/
  	public function submitForm(array &$form, FormStateInterface $form_state) { 
	    parent::submitForm($form, $form_state);
	  
	    $this->config('locationtime.adminsettings')
	      ->set('country', $form_state->getValue('country'))
	      ->set('city', $form_state->getValue('city'))
	      ->set('timezone', $form_state->getValue('timezone'))
	      ->set('timezone_options', $form_state->getValue('timezone_options'))
	      ->save();  
  	}   
}

