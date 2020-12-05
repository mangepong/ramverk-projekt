<?php

namespace mange\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use mange\Question\HTMLForm\CreateQuestionForm;
use mange\Question\HTMLForm\CreateAnswerForm;
use mange\Question\HTMLForm\CreateCommentForm;
use mange\User\User;
use mange\Question\Answer;
use mange\Tags\TagQuestion;
use mange\Filter\Filter;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->filter = new Filter();
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {

        $page = $this->di->get("page");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $allQuestions = $question->findAllOrderBy("created DESC");

        $page->add("question/beforeQuestions", [
            "allQuestions" => $allQuestions,
        ]);

        foreach($allQuestions as $question) {
            $user = new User();
            $user->setDb($this->di->get("dbqb"));
            $userInfo = $user->find('id', $question->userId);
            $answer = new Answer();
            $answer->setDb($this->di->get("dbqb"));
            $answerSum = $answer->selectWhere("count(*) as num", "questionid = ?", $question->id);
            $parsedText = $this->filter->markdown($question->text);
            $page->add("question/questions", [
                "question" => $question,
                "userInfo" => $userInfo,
                "answerSum" => $answerSum,
                "parsedText" => $parsedText,
            ]);
        }

        return $page->render([
            "title" => "Alla frågor",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        if (!$this->di->session->get('loggedIn')) {
            return $this->di->response->redirect("user/login");
        }

        $page = $this->di->get("page");
        $form = new CreateQuestionForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Skapa en fråga",
        ]);
    }


    /**
     * Show one question.
     *
     * @param int $id The id of the question
     *
     * @return void
     */
    public function viewAction(int $id)
    {

        $page = $this->di->get("page");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $theQuestion = $question->find('id', $id);

        $TagQuestion = new TagQuestion();
        $TagQuestion->setDb($this->di->get("dbqb"));
        $tags = $TagQuestion->findAllWhere("questionid = ?", $id);

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find('id', $theQuestion->userId);

        if (!$this->di->session->get('loggedIn')) {
            $noUser = "disabled";
        }
        $parsedText = $this->filter->markdown($question->text);
        $page->add("question/question", [
            "question" => $theQuestion,
            "userInfo" => $user,
            "tags" => $tags,
            "parsedText" => $parsedText,
        ]);

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $allComments = $comment->findAllWhere("questionid = ? and answerid = ?", [$id, '']);

        foreach($allComments as $oneComment) {
            $user = new User();
            $user->setDb($this->di->get("dbqb"));
            $userInfo = $user->find('id', $oneComment->userId);
            $parsedText = $this->filter->markdown($oneComment->text);
            $page->add("question/showComment", [
                "comment" => $oneComment,
                "userInfo" => $userInfo,
                "parsedText" => $parsedText,
            ]);
        };


        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $allAnswers = $answer->findAllWhereOrderBy("id DESC", "questionid = ?", $id);

        foreach($allAnswers as $answer) {
            $user = new User();
            $user->setDb($this->di->get("dbqb"));
            $userInfo = $user->find('id', $answer->userId);
            $parsedText = $this->filter->markdown($answer->text);
            $page->add("question/answer", [
                "theQuestion" => $theQuestion,
                "answer" => $answer,
                "userInfo" => $userInfo,
                "loggedIn" => $this->di->session->get('loggedIn'),
                "parsedText" => $parsedText,
            ]);
            $comment = new Comment();
            $comment->setDb($this->di->get("dbqb"));
            $allComments = $comment->findAllWhere("questionid = ? and answerid = ?", [$id, $answer->id]);
            foreach($allComments as $oneComment) {
                $user = new User();
                $user->setDb($this->di->get("dbqb"));
                $userInfo = $user->find('id', $oneComment->userId);
                $parsedText = $this->filter->markdown($oneComment->text);
                $page->add("question/showComment", [
                    "comment" => $oneComment,
                    "userInfo" => $userInfo,
                    "parsedText" => $parsedText,
                ]);
            };
        };

        if ($this->di->session->get('loggedIn')) {
            $form = new CreateAnswerForm($this->di, $id);
            $form->check();
            $page->add("anax/v2/article/default", [
                "content" => $form->getHTML(),
            ]);
        }

        return $page->render([
            "title" => "$question->title",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function commentActionGet() : object
    {
        if (!$this->di->session->get('loggedIn')) {
            return $this->di->response->redirect("user/login");
        }

        $questionid = $this->di->request->getGet("question");
        $answerid = $this->di->request->getGet("answer") ?? null;

        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        if ($answerid) {
            $answer = new Answer();
            $answer->setDb($this->di->get("dbqb"));
            $replyTo = $answer->findWhere('id = ? and questionid = ?', [$answerid, $questionid]);

            $userInfo = $user->find('id', $replyTo->userId);
        } else {
            $question = new Question();
            $question->setDb($this->di->get("dbqb"));
            $replyTo = $question->find('id', $questionid);

            $userInfo = $user->find('id', $replyTo->id);
        }

        $form = new CreateCommentForm($this->di, $questionid, $answerid);
        $form->check();

        $page = $this->di->get("page");
        $parsedText = $this->filter->markdown($replyTo->text);
        $page->add("question/giveComment", [
            "replyTo" => $replyTo,
            "userInfo" => $userInfo,
            "content" => $form->getHTML(),
            "parsedText" => $parsedText,
        ]);

        return $page->render([
            "title" => "Kommentera",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function commentActionPost() : void
    {
        $id        = $this->di->session->get('loggedIn');
        $text        = $this->di->request->getPost("Kommentera");
        $questionId  = $this->di->request->getPost("questionid");
        $answerId    = $this->di->request->getPost("answerid") ?? null;
        $createdDate = date("Y/m/d G:i:s", time());

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->userId = $id;
        $comment->text = $text;
        $comment->questionid = $questionId;
        $comment->answerid = $answerId;
        $comment->save();

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $comment->userId);
        $user->save();

        $this->di->response->redirect("question/view/{$questionId}");
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function acceptActionGet() : object
    {
        $userId      = $this->di->session->get('loggedIn');
        $questId  = $this->di->request->getGet("questionId");
        $answerId = $this->di->request->getGet("answerId");

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $currAnswer = $answer->find("id", $answerId);
        if ($currAnswer->accepted == 1) {
            $currAnswer->accepted = 0;
        } else {
            $currAnswer->accepted = 1;
        }

        $currAnswer->save();

        $this->di->response->redirect("question/view/{$questId}");
    }
}
