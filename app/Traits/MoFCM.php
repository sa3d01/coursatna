<?php
/**
 * Created by MoWagdy
 * Date: 2019-06-23
 * Time: 10:57 PM
 */

namespace App\Traits;

use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\Topics;
use LaravelFCM\Message\OptionsBuilder;

trait MoFCM
{
    protected function sendAndroidTopicFCM($topicName, $dataObject)
    {
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->setData($dataObject);
        $data = $dataBuilder->build();

        $topic = new Topics();
        $topic->topic($topicName);

        $topicResponse = FCM::sendToTopic($topic, null, null, $data);

        //$topicResponse->isSuccess();
        //$topicResponse->shouldRetry();
        //$topicResponse->error();
    }

    protected function sendAndroidSingleFCM($fcmToken, $dataObject)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->setData($dataObject);

        $option = $optionBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($fcmToken, $option, null, $data);
    }

    protected function sendIosTopicFCM($topicName, $dataObject)
    {
        $notificationBuilder = new PayloadNotificationBuilder('the Title from messageDetailFCM');//Title
        $notificationBuilder->setBody('the Body of the messageDetailFCM')//Body
        ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->setData($dataObject);
        //$dataBuilder->addData($data);

        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $topic = new Topics();
        $topic->topic($topicName);

        $topicResponse = FCM::sendToTopic($topic, null, $notification, $data);
    }

    protected function sendIosSingleFCM($fcmToken, $dataObject)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->setData($dataObject);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($fcmToken, $option, $notification, $data);
    }
}
