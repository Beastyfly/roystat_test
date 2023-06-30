<?php



namespace models;

use Exception;

class ApiFetch
{
    private $subdomain;
    private $link;
    private $postfix_link;
    private $data = [];
    private $headers = [];



    public function insertToAMO($name, $email, $tel, $price) {
        include 'Database.php';
        $database = new Database();
        $access_token = $database->fetchToken();
        $this->subdomain = 'dimabeasty1';
        $this->postfix_link = '/api/v4/leads';
        $this->link = 'https://' . $this->subdomain . '.amocrm.ru/'. $this->postfix_link;
        $this->headers = [
            "Accept: application/json",
            'Authorization: Bearer ' . $access_token
        ];
        $this->data = array(
            [
                'name' => $name,
                'price' => $price,
                '_embedded[contacts]'  => [
                    [
                        'custom_fields_values' => [
                            0 => [
                                'field_id' => '954649',
                                'values' => [
                                    0 => [
                                        'value' => 'unsorted_example@example.com',
                                    ],
                                ],
                            ],
                        ],
                    ]
                ]
                ]
        );
        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        /** Устанавливаем необходимые опции для сеанса cURL  */
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $this->link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($this->data, JSON_UNESCAPED_UNICODE));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);//Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //$response = json_decode($out, true);
        curl_close($curl);

        /** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];
        try
        {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        } catch(\Exception $e)
        {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }
        $message_error = 1;
        $response = json_decode($out, true);
       // $response_links = $response['links'];
        return $message_error;
    }

}