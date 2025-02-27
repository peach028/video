<?php
// 定义 sp.txt 文件的路径
$filePath = 'sp.txt';

// 初始化响应数据数组
$response = [
    'code' => 200,
    'msg' => '请求成功',
    'data' => null
];

// 检查文件是否存在
if (!file_exists($filePath)) {
    $response['code'] = 404;
    $response['msg'] = "文件 sp.txt 不存在。";
} else {
    // 读取文件内容并按行分割成数组
    $videoLinks = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // 检查是否有视频链接
    if (empty($videoLinks)) {
        $response['code'] = 404;
        $response['msg'] = "未找到视频链接。";
    } else {
        // 生成随机索引
        $index = rand(0, count($videoLinks) - 1);

        // 获取对应的视频链接
        $videoLink = $videoLinks[$index];

        // 替换非标准的斜杠转义
        $videoLink = str_replace('\\/', '/', $videoLink);

        $response['data'] = $videoLink;
    }
}

// 设置响应头，明确指定字符编码为 UTF-8
header('Content-Type: application/json; charset=UTF-8');
http_response_code(200);

// 输出 JSON 数据，使用 JSON_UNESCAPED_SLASHES 和 JSON_UNESCAPED_UNICODE 避免斜杠和中文转义
echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>