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
            $bot_token = "7659103234:AAH95OkCUakcZzqmWc37OeObc8XtA-sP8oc";
            $chat_id = "217349575";
            $complete_url = "https://api.telegram.org/bot" . $bot_token . "/sendMessage?chat_id=" . $chat_id . "&text=";
            $chat_id = "";
            /*$from = "noreply@do-sites.ru";
            $to = "matador-ver2.0@yandex.ru";
            $subject = "Оповещение с crm.do-sites.ru о ближайших задачах";*/
            $message = "Количество задач: " . count($arrTasks) . "%0A";

            foreach ($arrTasks as $item) {
                $message .= "Задача: " . $item['id'] .  "%0AКлиент: " . $item['client'] . "%0A";
            }

            file_get_contents($complete_url . $message);

            /*$headers = [
                'From' => "Do Sites CRM <$from>",
                'X-Sender' => "Do Sites CRM <$from>",
                'X-Mailer' => 'PHP/' . phpversion(),
                'X-Priority' => '1',
                'Return-Path' => "$from",
                'MIME-Version' => '1.0',
                'Content-Type' => 'text/html; charset=iso-8859-1'
            ];*/

            //mail($to,$subject,$message, $headers);

            echo "The message was sent. \n";
        }

        return ExitCode::OK;
    }
}

