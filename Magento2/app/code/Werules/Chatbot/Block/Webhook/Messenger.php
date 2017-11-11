<?php
/**
 * Magento Chatbot Integration
 * Copyright (C) 2017  
 * 
 * This file is part of Werules/Chatbot.
 * 
 * Werules/Chatbot is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Werules\Chatbot\Block\Webhook;

class Messenger extends \Werules\Chatbot\Block\Webhook\Index
{
//    protected $_messenger;

//    public function __construct(
//        \Magento\Framework\View\Element\Template\Context $context,
//        \Werules\Chatbot\Helper\Data $helperData,
//        \Werules\Chatbot\Model\ChatbotAPI $chatbotAPI,
//        \Werules\Chatbot\Model\Message $message,
//        \Werules\Chatbot\Model\Api\Messenger $messenger
//    )
//    {
//        parent::__construct($context, $helperData, $chatbotAPI, $message);
//        $this->_messenger = $messenger;
//    }

    public function getVerificationHub($hub_token)
    {
        $api_token = $this->_helper->getConfigValue('werules_chatbot_messenger/general/api_key');
        $messenger = $this->_chatbotAPI->initMessengerAPI($api_token);
        $result = $messenger->verifyWebhook($hub_token);

        if ($result)
            return $result;
        else
            return $this->_helper->getJsonErrorResponse();
    }

    public function requestHandler()
    {
        $api_token = $this->_helper->getConfigValue('werules_chatbot_messenger/general/api_key');
        $messenger = $this->_chatbotAPI->initMessengerAPI($api_token);
        $messageObject = new \stdClass();
        $messageObject->senderId = $messenger->ChatID();
        $messageObject->content = $messenger->Text();
        $messageObject->status = $this->_define::PROCESSING;
        $messageObject->direction = $this->_define::INCOMING;
        $messageObject->chatType = $this->_define::MESSENGER_INT;
        $messageObject->chatMessageId = $messenger->MessageID();
        $datetime = date('Y-m-d H:i:s');
        $messageObject->createdAt = $datetime;
        $messageObject->updatedAt = $datetime;

        $result = $this->messageHandler($messageObject);
//        $messageModel = $this->_messageModel->create();
//        $messageModel->setSenderId($messenger->ChatID());
//        $messageModel->setContent($messenger->Text());
//        $messageModel->setStatus(1); // 0 -> not processed / 1 -> processing / 2 -> processed
//        $messageModel->setDirection(0); // 0 -> incoming / 1 -> outgoing
//        $messageModel->setChatMessageId($messenger->MessageID());
//        $datetime = date('Y-m-d H:i:s');
//        $messageModel->setCreatedAt($datetime);
//        $messageModel->setUpdatedAt($datetime);

//        try {
//            $messageModel->save();
//        } catch (\Magento\Framework\Exception\LocalizedException $e) {
//            return $this->_helper->getJsonErrorResponse();
//        }
//        $this->_helper->processMessage($messageModel->getMessageId());
//
//        return $this->_helper->getJsonSuccessResponse();
        return $result;
    }
}
