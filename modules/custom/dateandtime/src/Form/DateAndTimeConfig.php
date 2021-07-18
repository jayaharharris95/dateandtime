<?php  

/**  
 * @file  
 * Contains Drupal\dateandtime\Form\DateAndTimeConfig.  
 */  

namespace Drupal\dateandtime\Form;  

use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class DateAndTimeConfig extends ConfigFormBase {  
  /**  
   * {@inheritdoc}  
   */  
  protected function getEditableConfigNames() {  
    return [  
      'dateandtime.settings',  
    ];  
  }  

  /**  
   * {@inheritdoc}  
   */  
  public function getFormId() {  
    return 'dateandtime_form';  
  }  

    /**  
   * {@inheritdoc}  
   */  
  public function buildForm(array $form, FormStateInterface $form_state) {  

    $form = parent::buildForm($form, $form_state);
    $config = $this->config('dateandtime.settings');

    $form['country'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Country'),  
      '#description' => $this->t('Enter Country Name'),  
      '#default_value' => $config->get('country'),  
    ];

    $form['city'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('City'),  
      '#description' => $this->t('Enter City Name'),  
      '#default_value' => $config->get('city'),  
    ];

    $form['time_zone'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Select Time Zone'),
      '#options' => [
        '1' => $this
          ->t('America/Chicago'),
        '2' => $this
          ->t('America/New_York'),
        '3' => $this
          ->t('Asia/Tokyo'),
        '4' => $this
          ->t('Asia/Dubai'),
        '5' => $this
          ->t('Asia/Kolkata'),
        '6' => $this
          ->t('Europe/Amsterdam'),
        '7' => $this
          ->t('Europe/Oslo'),
        '8' => $this
          ->t('Europe/London'),        
      ],
      '#default_value' => $config->get('time_zone'),
    ];

    return parent::buildForm($form, $form_state);  
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $key = $form_state->getValue('time_zone');
    $val = $form['time_zone']['#options'][$key];
    $config = $this->config('dateandtime.settings');
    $config->set('country', $form_state->getValue('country'));
    $config->set('city', $form_state->getValue('city'));
    $config->set('time_zone', $val);
    $config->save();
    return parent::submitForm($form, $form_state);
  }
}  