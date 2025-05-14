@extends('layouts.admin')

@section('content')
<div class="container" id="app">
    <h2>欢迎来到管理后台</h2>
    <p>@{{ message }}</p>  <!-- Vue 将动态渲染这个变量 -->
    <button @click="testClick" class="btn btn-primary">测试按钮</button>
</div>
@endsection
