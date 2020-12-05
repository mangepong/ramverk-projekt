<?php

namespace mange\Question\HTMLForm;

use mange\Question\Question;
use mange\Question\Answer;
use mange\Tags\TagQuestion;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use mange\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "Svara" => [
                    "type"        => "textarea",
                    "placeholder" => "Har du ett svar?",
                ],

                "id" => [
                    "type"        => "hidden",
                    "value"       => $id,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skicka",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $userId      = $this->di->session->get('loggedIn');
        $text        = $this->form->value("Svara");
        $id          = $this->form->value("id");

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->userId = $userId;
        $answer->text = $text;
        $answer->questionid = $id;

        $answer->save();

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $userId);
        $user->save();


        return true;
    }
}
