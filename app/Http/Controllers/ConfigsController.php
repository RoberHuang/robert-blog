<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\ConfigCreateRequest;
use App\Http\Requests\ConfigSetRequest;
use App\Http\Requests\ConfigUpdateRequest;
use App\Repositories\Contracts\ConfigRepository;
use Illuminate\Http\Request;

class ConfigsController extends AdminController
{
    protected $repository;

    public function __construct(ConfigRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    public function index()
    {
        $configs = $this->repository->orderBy('order', 'asd')->paginate(config('blog.posts_per_page'));

        $configs['data'] = $this->parserType($configs['data']);

        return view('/admin.configs.index', $configs);
    }

    public function create()
    {
        return view('/admin.configs.add');
    }

    public function store(ConfigCreateRequest $request)
    {

        $config = $this->repository->create($request->fillData());

        return redirect('/admin/configs')->with('success', '配置项「' . $config['data']['name'] . '」创建成功.');
    }

    public function edit($id)
    {
        $config = $this->repository->find($id);

        return view('/admin.configs.edit', $config);
    }

    public function update(ConfigUpdateRequest $request, $id)
    {
        $config = $this->repository->update($request->fillData(), $id);

        return redirect('/admin/configs')->with('success', '配置项「' . $config['data']['name'] . '」修改成功.');
    }

    public function setOrder(Request $request){
        $this->repository->update($request->input('order'), $request->input('id'));

        return ['status' => '1', 'msg' => '排序成功'];
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        $this->putFile();

        return redirect('/admin/configs')->with('success', '删除成功.');
    }

    public function setConf(ConfigSetRequest $request){
        foreach($request->input('conf_id') as $key=>$val){
            $this->repository->update([
                'content'=> $request->input('content')[$key],
                'order' => $request->input('order')[$key]
            ], $val);
        }
        $this->putFile();

        return redirect('/admin/configs')->with('success', '配置保存成功.');
    }

    protected function putFile()
    {
        $configs = $this->repository->pluck('content', 'name')->all();
        $path = base_path().'/config/web.php';

        $str = '<?php return '.var_export($configs,true).';';
        file_put_contents($path,$str);
    }

    protected function parserType(array $configs)
    {
        foreach ($configs as $k => $config) {
            switch ($config['type']) {
                case 'input':
                    $configs[$k]['_html'] = '<input type="text" class="" name="content[]" value="'. $config['content'] .'">';
                    break;
                case 'textarea':
                    $configs[$k]['_html'] = '<textarea type="text" class="" cols="30" rows="2" name="content[]">'.$config['content'].'</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $arr = explode(',', $config['value']);
                    $str = '';
                    foreach($arr as $m => $n){
                        //1|开启
                        $r = explode('|',$n);
                        $c = $config['content'] == $r[0] ? ' checked ' : '';
                        $str .= '<input type="radio" name="content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $configs[$k]['_html'] = $str;
                    break;
            }
        }

        return $configs;
    }
}
