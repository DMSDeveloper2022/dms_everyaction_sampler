<?php

namespace   PJ_EA_Membership\Includes\Import;

class Email_Import
{

    const API_ENDPOINT =  '/api/read-emails';
    const EMAIL_ADDRESS = 'developer@dukemediaservices.com';
    const EMAIL_PSW = '*jHL947790(%';
    const EMAIL_HOST = '{imap.gmail.com:993/ssl}INBOX';

    function __construct()
    {
    }
    function readEmails()
    {
        // Connect to the email server
        $mailbox = \imap_open($_SERVER['SERVER_NAME'] . static::EMAIL_HOST, static::EMAIL_ADDRESS, static::EMAIL_PSW);

        // Check if the connection was successful
        if (!$mailbox) {
            die('Unable to connect to the email server');
        }

        // Fetch email headers
        $emails = \imap_search($mailbox, 'EveryAction Scheduled Report - PJ Membership Members Sync - Full');

        $emailData = [];

        if ($emails) {
            foreach ($emails as $emailId) {
                $header = \imap_headerinfo($mailbox, $emailId);

                // Extract relevant email data (e.g., subject, sender, recipient)
                $emailData[] = [
                    'subject' => $header->subject,
                    'from' => $header->fromaddress,
                    'to' => $header->toaddress,
                ];
            }
        }

        // Close the connection to the email server
        imap_close($mailbox);

        return $emailData;
    }
    static function read_email()
    {

        $emailImport = new static();


        // Call a function to read emails and retrieve the data
        $emailData = $emailImport->readEmails();

        // Set the appropriate headers
        header('Content-Type: application/json');

        // Return the email data as JSON response
        echo json_encode($emailData);
        exit();
    }
}
// namespace\Email_Import::read_email();
