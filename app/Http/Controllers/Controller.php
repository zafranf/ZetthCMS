<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ErrorLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// use Yajra\DataTables\Facades\DataTables;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $mail_id;
    public $isAdminPage = false;

    public function __construct()
    {
        $host = parse_url(url('/'))['host'];
        if (strpos($host, 'admin') !== false) {
            $this->isAdminPage = true;
        }
    }

    public function sendMail($par)
    {
        $status = false;

        $mail = \Mail::send($par['view'], $par['data'], function ($mail) use ($par) {
            /* Set Sender */
            if (isset($par['from'])) {
                if (is_array($par['from'])) {
                    if (isset($par['from']['email'])) {
                        $from_name = isset($par['from']['name']) ? $par['from']['name'] : '';
                        $mail->from($par['from']['email'], $from_name);
                    }
                } else {
                    $mail->from($par['from']);
                }
            } else {
                $mail->from($cfg['username']);
            }

            /* Set Sender 'Reply To' */
            if (isset($par['reply_to'])) {
                if (is_array($par['reply_to'])) {
                    if (isset($par['reply_to']['email'])) {
                        $replyto_name = isset($par['reply_to']['name']) ? $par['reply_to']['name'] : '';
                        $mail->replyTo($par['reply_to']['email'], $replyto_name);
                    }
                } else {
                    $mail->replyTo($par['reply_to']);
                }
            }

            /* Set 'To' Recipient */
            if (isset($par['to'])) {
                if (is_array($par['to'])) {
                    /* Check if recipient more than 1 */
                    if (isset($par['to'][0])) {
                        foreach ($par['to'] as $key => $val) {
                            if (isset($val['email'])) {
                                $to_name = isset($val['name']) ? $val['name'] : '';
                                $mail->to($val['email'], $to_name);
                            } else {
                                $mail->to($val);
                            }
                        }
                    }
                    /* Check if recipient only 1 and using name */
                    else if (isset($par['to']['email'])) {
                        $to_name = isset($par['to']['name']) ? $par['to']['name'] : '';
                        $mail->to($par['to']['email'], $to_name);
                    }
                } else {
                    /* Check if recipient only 1 and just email */
                    $mail->to($par['to']);
                }
            }

            /* Set 'Cc' Recipient */
            if (isset($par['cc'])) {
                if (is_array($par['cc'])) {
                    /* Check if 'Cc' recipient more than 1 */
                    if (isset($par['cc'][0])) {
                        foreach ($par['cc'] as $key => $val) {
                            if (isset($val['email'])) {
                                $cc_name = isset($val['name']) ? $val['name'] : '';
                                $mail->cc($val['email'], $cc_name);
                            } else {
                                $mail->cc($val);
                            }
                        }
                    }
                    /* Check if 'Cc' recipient only 1 and using name */
                    else if (isset($par['cc']['email'])) {
                        $cc_name = isset($par['cc']['name']) ? $par['cc']['name'] : '';
                        $mail->cc($par['cc']['email'], $cc_name);
                    }
                } else {
                    /* Check if 'Cc' recipient only 1 and just email */
                    $mail->cc($par['cc']);
                }
            }

            /* Set 'Bcc' Recipient */
            if (isset($par['bcc'])) {
                if (is_array($par['bcc'])) {
                    /* Check if 'Bcc' recipient more than 1 */
                    if (isset($par['bcc'][0])) {
                        foreach ($par['bcc'] as $key => $val) {
                            if (isset($val['email'])) {
                                $bcc_name = isset($val['name']) ? $val['name'] : '';
                                $mail->bcc($val['email'], $bcc_name);
                            } else {
                                $mail->bcc($val);
                            }
                        }
                    }
                    /* Check if 'Bcc' recipient only 1 and using name */
                    else if (isset($par['bcc']['email'])) {
                        $bcc_name = isset($par['bcc']['name']) ? $par['bcc']['name'] : '';
                        $mail->bcc($par['bcc']['email'], $bcc_name);
                    }
                } else {
                    /* Check if 'Bcc' recipient only 1 and just email */
                    $mail->bcc($par['bcc']);
                }
            }

            /* Set Attachments */
            if (isset($par['attachments'])) {
                if (is_array($par['attachments'])) {
                    /* Check if attachment more than 1 */
                    if (isset($par['attachments'][0])) {
                        foreach ($par['attachments'] as $key => $val) {
                            if (isset($val['file'])) {
                                $attachment_name = isset($val['name']) ? $val['name'] : '';
                                $mail->attach($val['file'], $attachment_name);
                            } else {
                                $mail->attach($val);
                            }
                        }
                    }
                    /* Check if attachment only 1 and using name */
                    else if (isset($par['attachments']['file'])) {
                        $attachment_name = isset($par['attachments']['name']) ? $par['attachments']['name'] : '';
                        $mail->attach($par['attachments']['file'], $attachment_name);
                    }
                } else {
                    /* Check if attachment only 1 and just filename */
                    $mail->attach($par['attachments']);
                }
            }

            /* Set email subject */
            $mail->subject($par['subject']);

            /* Get id */
            $this->mail_id = $mail->getId();
        });

        if ($mail) {
            $status = true;
        }

        return $status;
    }

    public function activityLog($description)
    {
        /* Filter password */
        $sensor = 'xxx';
        if (isset($_POST['password'])) {
            $_POST['password'] = $sensor;
        }
        if (isset($_POST['password_confirmation'])) {
            $_POST['password_confirmation'] = $sensor;
        }
        if (isset($_POST['user_password'])) {
            $_POST['user_password'] = $sensor;
        }

        $act = new ActivityLog;
        $act->description = $description;
        $act->method = \Request::method();
        $act->path = \Request::path();
        $act->ip = \Request::server('REMOTE_ADDR');
        $act->get = json_encode($_GET);
        $act->post = json_encode($_POST);
        $act->files = json_encode($_FILES);
        $act->user_id = \Auth::user()->id ?? null;
        $act->save();
    }

    public function errorLog($e)
    {
        $log = [
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => $e->getMessage(),
            'params' => \Request::all(),
            'path' => \Request::path(),
            'trace' => $e->getTrace(),
        ];
        if (isset($e->data)) {
            $log['data'] = $e->data;
        }

        /* save to log file */
        \Log::error('error_catch', $log);

        /* save to database */
        ErrorLog::create([
            'code' => $log['code'],
            'path' => $log['path'],
            'file' => $log['file'],
            'line' => $log['line'],
            'message' => $log['message'],
        ]);

        /* return error */
        $error = ($e->getCode() != 0) ? $e->getMessage() : 'Error :(';
        if (env('APP_DEBUG')) {
            $error = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
        }

        return $error;
    }

    /**
     * [_upload_file description]
     * @param  array  $par [description]
     * @return [type]      [description]
     */
    public function uploadFile($par = [])
    {
        /* set variable */
        $file = $par['file'];
        $folder = public_path($par['folder']);
        $name = $par['name'];
        $type = $par['type'];
        $ext = $par['ext'];

        /* checking folder */
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        /* process upload */
        $move = $file->move($folder, $name . "." . $ext);

        return $move;
    }

    /**
     * [uploadImage description]
     * @param  [type] $par [description]
     * @return [type]      [description]
     */
    public function uploadImage($par = [], $optimation = false)
    {
        /* preparing image file */
        $img = \Image::make($par['file']);

        /* folder check */
        $folders = explode('/', $par['folder']);
        $fldr = public_path('');
        foreach ($folders as $folder) {
            if ($folder != '') {
                $fldr .= '/' . $folder;
                if (!is_dir($fldr)) {
                    mkdir($fldr);
                }
            }
        }
        $folder = public_path($par['folder']);

        /* insert watermark */
        if (isset($par['watermark'])) {
            $wmImg = \Image::make($par['watermark']);
            $img->insert($wmImg, 'center');
        }

        /* save original */
        $img->save($folder . $par['name'] . '.' . $par['ext']);

        /* image optimation */
        if ($optimation) {
            $this->uploadImageOptimation($par);
        }

        return true;
    }

    /**
     * [uploadImageOptimation description]
     * @param  [type] $par [description]
     * @return [type]      [description]
     * source: https://gist.github.com/ianmustafa/b8ab7dfd490ff2081ac6d29d828727db
     */
    public function uploadImageOptimation($par)
    {
        /* set 5 menit */
        ini_set('max_execution_time', 300);

        /* ukuran gambar */
        $imageconfig = array(
            'thumbnail' => array(
                'x' => 100,
                'y' => 75,
                'b' => 2,
            ),
            'small' => array(
                'x' => 200,
                'y' => 150,
                'b' => 4,
            ),
            'medium' => array(
                'x' => 400,
                'y' => 300,
                'b' => 8,
            ),
            'large' => array(
                'x' => 800,
                'y' => 600,
                'b' => 16,
            ),
            'opengraph' => array(
                'x' => 1200,
                'y' => 630,
                'b' => 18,
            ),
        );

        /* siapkan image */
        $file = public_path($par['folder'] . $par['name'] . "." . $par['ext']);

        /* optimasi gambar */
        foreach ($imageconfig as $suffix => $config) {
            /* folder check */
            $nfolder = public_path($par['folder'] . $suffix);
            if (!is_dir($nfolder)) {
                mkdir($nfolder);
            }

            /* file save location */
            $save = $nfolder . "/" . $par['name'] . '.' . $par['ext'];

            /* hitung aspek rasio gambar */
            $or = $config['x'] / $config['y'];

            /* clone objek gambar dasar untuk dijadikan gambar utama,
            lalu ubah ukurannya */
            $mainimage = \Image::make($file);
            $mainimage->resize($config['x'], $config['y'], function ($constraint) {
                $constraint->aspectRatio();
            });
            $w = $mainimage->width();
            $h = $mainimage->height();
            $r = $w / $h;

            /* jika rasio gambar tidak sesuai dengan dimensi target,
            kita bisa membuat gambar latar blur untuk mengisi ruang kosong di sekitar gambar */
            if ($r != $or) {
                /* buat kanvas baru */
                $compimage = \Image::canvas($config['x'], $config['y'], '#fff');
                $compimage->encode('jpg');

                /* Ambil dimensi baru dari gambar utama yang telah diubah ukurannya */
                $nw = $mainimage->width();
                $nh = $mainimage->height();

                /* set ukuran gambar latar */
                $bgw = $r < $or ? $config['x'] : ceil($config['y'] * $r);
                $bgh = $r < $or ? ceil($config['x'] * $h / $w) : $config['y'];

                /* Lalu clone gambar dasar untuk dijadikan gambar latar,
                ubah ukurannya, lalu blur dan set opacity-nya */
                $bgimage = \Image::make($file);
                $bgimage->resize($bgw, $bgh);
                $bgimage->blur($config['b']);
                $bgimage->opacity(50);

                /* gabungkan semua gambar menjadi satu */
                $compimage->insert($bgimage, 'center');
                $compimage->insert($mainimage, 'center');
                $compimage->save($save, 60);

                /* destroy */
                $mainimage->destroy();
                $bgimage->destroy();
                $compimage->destroy();
            }

            /* jika dimensinya sesuai, langsung pakai gambar utama */
            else {
                /* clone gambar utama untuk dijadikan output */
                $mainimage->save($save, 60);
                $mainimage->destroy();
            }
        }

        return true;
    }

    /**
     * Generate datatable server side
     *
     * @param [type] $request
     * @param [type] $collection
     * @return void
     */
    protected function generateDataTable($request, $collection)
    {
        if ($collection instanceof Illuminate\Database\Eloquent\Builder) {
            $collection = $collection->get();
        }

        return \Datatables::collection($collection)->addColumn('action', 'test')->make();
    }
}
