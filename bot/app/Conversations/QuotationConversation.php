<?php


namespace App\Conversations;


namespace App\Conversations;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Foundation\Inspiring;
use phpDocumentor\Reflection\Types\Boolean;

class QuotationConversation extends Conversation
{
    protected $firstname;

    protected $email;


    public function askFirstname()
    {
        $this->ask('Bienvenido!, ¿Cuál es su nombre?', function (Answer $answer) {
            // Save result
            $this->firstname = $answer->getText();

            $this->say($this->getCorrectGreeting() . ', ' . $this->firstname);
            $this->askQuotation();
        });
    }


    public function askQuotation()
    {


        $question = Question::create('¿Qué es lo que necesita cotizar?')
            ->fallback('Por favor, seleccione el modelo que se encuentra en la pagina')
            ->callbackId('ask_tv')
            ->addButtons([
                Button::create('Televisores')->value('tv'),
                Button::create('Smartphones')->value('sphone'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'tv') {
                    $this->askTv();
                } else {
                    $this->askSphone();
                }
            }
        });
    }


    public function askTv()
    {
        $question = Question::create('Indicar Marca del televisor')
            ->callbackId('ask_quotation');

        $this->ask($question, function (Answer $answer) {

            $infoTv = array('LG', 'SAMSUNG', 'SONY');
            foreach ($infoTv as &$list) {
                if (strtoupper ($answer->getText()) === $list) {
                    $this->say('se ha seleccionado ' . $list);
                    $this->askEmail();
                    break;
                } else {
                    $this->say('Seleccionar alguno de estas Marcas Lg, Samsung o Sony');
                    break;
                }
            }

        });
    }

    public function askSphone()
    {

        $question = Question::create('Indicar Marca del smartphone')
            ->callbackId('ask_quotation');

        return $this->ask($question, function (Answer $answer) {

            $infoSphone = array('LG', 'SAMSUNG', 'SONY');
            foreach ($infoSphone as list($list)) {

                if (strtoupper ($answer->getText()) === $list) {
                    $this->say('se ha seleccionado ' . $list);
                    $this->askEmail();
                    break;
                } else {
                    $this->say('Seleccionar alguno de stas Marcas Lg, Samsung o Sony');
                    break;
                }
            }

        });

    }


    public function askEmail()
    {
        $this->ask('Favor de ingresar correo?', function (Answer $answer) {
            // Save result
            $this->email = $answer->getText();

            $this->say('Muchas gracias, ' . $this->firstname.' su cotización será enviada a su correo');
        });
    }

    public function run()
    {
        // This will be called immediately
        $this->askFirstname();
    }

    public function getCorrectGreeting()
    {
        $date = date("H");
        if ($date < 12) return "Buenos dias!";
        else if ($date < 18) return "Buenas tardes!";
        else return "Buenas noches!";
    }

}