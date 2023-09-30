<?php

namespace App\Http\Controllers;

use App\Mirror\ParseUrlHTML;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;

class MirrorController extends Controller
{
    protected array $rules = [
        'url' => ['required', 'url'],
        'waitTime' => ['sometimes', 'filled', 'integer'],
        'chromeArgs' => ['sometimes', 'array'],
        'preWait' => ['sometimes', 'boolean'],
    ];

    /**
     * @throws UniException
     */
    public function reflect(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            throw ManageException::build()
                ->log()->info()->b()
                ->desc()->failed('Validation')->b()
                ->fill();
        }

        $url = $request->input('url');
        $waitTime = $request->input('waitTime', config('app.parsing_wait_time'));
        $chromeArgs = $request->input('chromeArgs', []);
        $preWaitFlag = $request->input('preWait', false);

        $chromeArgs[] = '--user-data-dir=' . config('app.chrome_data_dir');
        if (config('app.disable_dev_shm_usage', false)) $chromeArgs[] = '--disable-dev-shm-usage';

        $parser = new ParseUrlHTML(
            config('app.selenium_uri'), $waitTime,
            $chromeArgs, $preWaitFlag
        );

        return response($parser->parse($url), 200)->header('Content-Type', 'text/plain');
    }
}
