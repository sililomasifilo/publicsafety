<?php

/*
 * Reusable library for push notifications.
 *
 * @author: anuragr@live.com
 */

class Push
{
        #passphrase for the iOS push notification private
        #key.
        private static $PASSPHRASE = '';
        private static $GOOGLE_KEY = '';

        public static function android($deviceTokens, $message)
        {
                // Set POST variables
                $url = 'https://android.googleapis.com/gcm/send';

                $fields = array(
                        'registration_ids' => $deviceTokens,
                        'data' => $message,
                );

                $headers = array(
                        'Authorization: key=' . $GOOGLE_KEY,
                        'Content-Type: application/json'
                );
                // Open connection
                $ch = curl_init();

                // Set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);

                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Disabling SSL Certificate support temporarly
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

                // Execute post
                $result = curl_exec($ch);
                if ($result === FALSE) {
                        #log 'Curl failed: ' . curl_error($ch);
                }

                // Close connection
                curl_close($ch);
                echo $result;
        }

        public static function iOS($deviceTokens, $message)
        {
                $ctx = stream_context_create();
                stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
                stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

                // Open a connection to the APNS server
                $fp = stream_socket_client(
                        'ssl://gateway.sandbox.push.apple.com:2195', $err,
                        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

                if (!$fp)
                        #log "Failed to connect: $err $errstr" . PHP_EOL

                        // Create the payload body
                        $body['aps'] = array(
                                'alert' => $message,
                                'sound' => 'default'
                        );

                // Encode the payload as JSON
                $payload = json_encode($body);

                // Build the binary notification
                $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                // Send it to the server
                $result = fwrite($fp, $msg, strlen($msg));

                if (!$result)
                {
                        #log 'Message not delivered' . PHP_EOL;
                }
                else
                {
                        #log 'Message successfully delivered' . PHP_EOL;
                }
                // Close the connection to the server
                fclose($fp);
        }
}
?>
