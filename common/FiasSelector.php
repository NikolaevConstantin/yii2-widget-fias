<?php

namespace ejen\fias\common\widgets;

use yii\helpers\Html;


class FiasSelector extends \yii\widgets\InputWidget
{
    private $_level = 3;

    public $method = "POST";

    public function run()
    {
        $id = Html::getInputId($this->model, $this->attribute);
        $name = Html::getInputName($this->model, $this->attribute);
        $options = $this->options;
        $value = $this->model->Address;
        /*add input address*/
        echo Html::textInput($name, $value, $options);
        /*connection script fias*/
        $this->view->registerJs("
            $('#".$id."').suggestions({
                token: '19f9d5a0f17196af01872717622391d4be51df35',
                type: 'ADDRESS',
                count: 5,
                /* Вызывается, когда пользователь выбирает одну из подсказок */
                onSelect: function(suggestion) {
                    console.log(suggestion);
                    $.ajax({
                        url: '/secondary-flat/lib',
                        type: 'POST',
                        data: { city_fias_id: suggestion.data.city_fias_id, street_fias_id: suggestion.data.street_fias_id, house_fias_id: suggestion.data.house_fias_id },
                        success: function (anw) {
                            console.log(anw);
                            if (anw != ''){
                                anw = JSON.parse(anw);
                                $.each(anw, function(key, value){
                                    $('#secondaryflat-'+key).val(value);
                                    console.log('key: '+key+' value: '+value);
                                });
                            } else{
                                console.log('error');
                            } 
                        }
                    })
                }
            });

        ");
        
    }
}
