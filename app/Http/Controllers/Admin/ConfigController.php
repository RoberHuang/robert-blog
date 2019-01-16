<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ConfigCreateRequest;
use App\Models\Admin\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends AdminController
{
    protected $fields = [
        'title' => '',
        'name' => '',
        'type' => 'input',
        'value' => '',
        'order' => 0,
        'content' => '',
        'remark' => ''
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configs = Config::orderBy('order', 'asc')->paginate(config('blog.posts_per_page'));

        foreach ($configs as $k => $config) {
            switch ($config->type) {
                case 'input':
                    $configs[$k]->_html = '<input type="text" class="" name="content[]" value="'. $config->content .'">';
                    break;
                case 'textarea':
                    $configs[$k]->_html = '<textarea type="text" class="" cols="30" rows="2" name="content[]">'.$config->content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $arr = explode(',', $config->value);
                    $str = '';
                    foreach($arr as $m => $n){
                        //1|开启
                        $r = explode('|',$n);
                        $c = $config->content == $r[0] ? ' checked ' : '';
                        $str .= '<input type="radio" name="content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $configs[$k]->_html = $str;
                    break;
            }
        }

        return view('admin.config.index')->withData($configs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.config.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigCreateRequest $request)
    {
        if($request->input('type') == 'radio') {
            if (!empty($request->input('value'))) {
                if (preg_match('/^(([0-9a-zA-Z]+\|[\w\x80-\xff]+,)+[0-9a-zA-Z]+\|[\w\x80-\xff]+)*$/i', $request->input('value')) === 0){
                    return redirect()->back()->withErrors(['类型值格式不正确.']);
                }
            } else {
                return redirect()->back()->withErrors(['类型值不能为空.']);
            }
        }

        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = $request->get($field)??$default;
        }
        $res = Config::create($data);

        return redirect('/admin/config')->with('success', '配置项「' . $res->name . '」创建成功.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $config = Config::findOrFail($id);

        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $config->$field);
        }

        return view('admin.config.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cate = Config::findOrFail($id);

        foreach ($this->fields as $field => $default) {
            $cate->$field = $request->get($field)??$default;
        }
        $cate->save();

        return redirect('admin/config')->with('success', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $config = Config::findOrFail($id);
        $config->delete();
        $this->putFile();

        return redirect('/admin/config')->with('success', '配置项「' . $config->name . '」已经被删除.');
    }

    public function setOrder(Request $request){
        $conf = Config::findOrFail($request->input('id'));

        $conf->conf_order = $request->input('order');
        $conf->update();

        return ['status' => '1', 'msg' => '排序成功'];
    }

    public function setConf(Request $request){
        foreach($request->input('conf_id') as $key=>$val){
            Config::where('id',$val)->update(['content'=>$request->input('content')[$key]]);
        }
        $this->putFile();

        return redirect('/admin/config')->with('success', '配置保存成功.');
    }

    protected function putFile(){
        $configs = Config::pluck('content','name')->all();
        $path = base_path().'/config/web.php';
        $str = '<?php return '.var_export($configs,true).';';
        file_put_contents($path,$str);
    }
}
