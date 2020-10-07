<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('function.php');


class Send_email
{
    function __construct()
    {
        // $this->CI = &get_instance();
    }

    function send($email, $type, $data = [])
    {
        // die();
        $curtime =  time();
        // $config = [
        //     'mailtype'  => 'html',
        //     'charset'   => 'utf-8',
        //     'protocol'  => 'smtp',
        //     'smtp_host' => 'mail.langkahjuara.com',
        //     'smtp_user' => 'untillness@langkahjuara.com',  // Email gmail
        //     'smtp_pass'   => 'untillNess1013',  // Password gmail
        //     'smtp_crypto' => 'tls',
        //     'smtp_port'   => 587,
        //     'crlf'    => "\r\n",
        //     'newline' => "\r\n"
        // ];
        // $this->CI->load->library('email', $config);
        // $this->CI->email->from('no-reply@YasaPintar!.com', 'Quantum Educational Center');
        // $this->CI->email->to($email);

        if ($type == 'lupa') {
            // $this->CI->email->subject('Reset Password Akun - Quantum Educational Center');
            $subject = 'Reset Password Akun - Quantum Educational Center';
        } else {
            // $this->CI->email->subject('Kode Verifikasi Akun - Quantum Educational Center');
            $subject = 'Kode Verifikasi Akun - Quantum Educational Center';
        }

        if ($type == 'lupa') {
            $url = base64_encode('reset;' . $email . ';' . $data['kode'] . ';' . $data['old'] . ';' . $curtime);
        } else {
            $url = base64_encode('verif;' . $email . ';' . $data['randomNumber'] . ';' . $curtime);
        }

        $url = base64_encode($url);

        $emailMessage = '';
        $emailMessage .= '<h2 style="color: black">Hallo, ' . $data['user_firstname'] . ' .!</h2>';
        if ($type == 'lupa') {
            $emailMessage .= '<p style="color: black">Anda meminta untuk mengubah password anda, silahkan klik tombol dibawah !</p>';
        } else {
            $emailMessage .= '<p style="color: black">Silakan tekan tombol di bawah ini untuk verifikasi alamat email.</p>';
        }
        $emailMessage .= '<br />';
        if ($type == 'lupa') {
            $emailMessage .= '<a href="' . base_url() . 'welcome/reset/' . $url . '" style="background-color: #55b9f3; padding: 10px 20px 10px 20px; margin-bottom: 10px; text-decoration: none; color: white">Ubah password</a>';
        } else {
            $emailMessage .= '<a href="' . base_url() . 'welcome/verifikasi/' . $url . '" style="background-color: #55b9f3; padding: 10px 20px 10px 20px; margin-bottom: 10px; text-decoration: none; color: white">Verifikasi</a>';
        }
        $emailMessage .= '<br />';
        $emailMessage .= '<br />';
        if ($type != 'lupa') {
            $emailMessage .= '<p style="color: black">Jika kamu tidak merasa mendaftar akun di YasaPintar!, abaikan saja email ini</p>';
        }
        $emailMessage .= '<p style="color: black">Terimakasih,</p>';
        $emailMessage .= '<p style="color: black">Panitia YasaPintar!.</p>';
        // $this->CI->email->message($emailMessage);

        // $res = $this->CI->email->send();

        // $subject  = 'Subject Pengiriman Email Uji Coba';
        $res = smtp_mail($email, $subject, $emailMessage, '', '', 0, 0);
        // var_dump($res);
        // die();
        return $res == 1 ? ['status' => true, 'url' => $url] : ['status' => false];
    }
}
