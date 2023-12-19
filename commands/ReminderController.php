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
            $to = "matador-ver2.0@yandex.ru";
            $subject = "Checking PHP mail";
            $message = "Количество задач: " . count($arrTasks) . "\n";

            foreach ($arrTasks as $item) {
                $message .= "<a target='_blank' href='http://crm.do-sites.ru/index.php?r=task%252Fview&id=" . $item['id'] . "'>Задача " . $item['id'] .  ". Клиент " . $item['client'] . "</a>\n";
            }

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

            echo "The email message was sent. \n";
        }

        return ExitCode::OK;
    }
}

