<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ClusterAssignmentNotification extends Notification
{
    use Queueable;

    protected $clusterId;
    protected $name;

    /**
     * Create a new notification instance.
     *
     * @param int $clusterId
     */
    public function __construct($clusterId, $name)
    {
        $this->clusterId = $clusterId;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    public function toMail($notifiable)
    {
        // Pesan yang berbeda berdasarkan cluster_id
        $messages = [
            1 => 'Selamat! Anda mendapatkan diskon 20% untuk semua produk premium kami. Jangan lewatkan kesempatan ini!',
            2 => 'Penawaran spesial: Beli 2 gratis 1 untuk produk pilihan kami. Ayo segera manfaatkan!',
            3 => 'Kami merindukan Anda! Dapatkan kode diskon Rp50.000 untuk pembelian pertama Anda setelah sekian lama tidak aktif.',
        ];

        $message = $messages[$this->clusterId] ?? 'Terima kasih telah menjadi pelanggan setia kami!';

        return (new MailMessage)
            ->subject("Penawaran Khusus untuk Cluster {$this->clusterId}")
            ->greeting("Halo, {$this->name}!")
            ->line($message)
            ->action('Lihat Penawaran', url('/'))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }
}
