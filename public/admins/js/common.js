/**
 * 排序
 * @param obj    当前对象
 * @param id    当前对象id
 * @param url    提交地址
 */
function changeOrder(obj, id, url){
    var token = $('meta[name="csrf-token"]').attr('content');
    var order = $(obj).val();
    $.post(url, {'_token': token, 'id': id, 'order': order}, function(data){
        if(data.status == 1){
            refresh();
        }
    });
}