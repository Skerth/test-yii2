<?php


namespace app\commands;

use Yii;
use yii\db\StaleObjectException;
use yii\symfonymailer\Mailer;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\ClientsTask;
use function Symfony\Component\Mime\toString;


class ReminderController extends Controller
{
    public function actionIndex()
    {
        $arrTasks = []; // Задачи, которые нужно отправить в письме.
        $checkDate = date('Y-m-d', strtotime('+5day'));

        $tasks = ClientsTask::find()
            ->andWhere("`archive` = '0'")
            ->andWhere("`check_date` <= '$checkDate'")
            ->all();

        foreach ($tasks as $task)
        {
            echo date('d M y', strtotime($task->check_date)) . " | ";
            echo $task->archive . " | ";
            echo $task->note . "\n";
            $modelTask = ClientsTask::findOne($task->id);
            $modelTask->archive = 1;
            $modelTask->update();

            $arrTasks[] = [
                'id' => $task->id,
                'client' => $task->client->name,
                'service' => ClientsTask::servicesArr[$task->service],
                'check_date' => $task->check_date,
                'price' => $task->price,
                'note' => $task->note,
            ];
        }

        if (count($arrTasks))
        {
            $from = "noreply@do-sites.ru";
            $to = "sklyatov@gmail.com";
            $subject = "Checking PHP mail";
            $message = "PHP mail works just fine";
            $headers = [
                'From' => "Do Sites CRM <$from>",
                'X-Sender' => "Do Sites CRM <$from>",
                'X-Mailer' => 'PHP/' . phpversion(),
                'X-Priority' => '1',
                'Return-Path' => "$from",
                'MIME-Version' => '1.0',
                'Content-Type' => 'text/html; charset=iso-8859-1'
            ];
            mail($to,$subject,$message, $headers);
            echo "The email message was sent.";
        }

        return ExitCode::OK;
    }
}
