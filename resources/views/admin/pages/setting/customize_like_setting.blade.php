@extends('admin.Layout.pagetemplate')
@section('head')
    <style>
        .avatar-upload {
            position: relative;


        }
        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }
        .avatar-upload .avatar-edit input {
            display: none;
        }
        .avatar-upload .avatar-edit input + label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
        }
        .avatar-upload .avatar-edit input + label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }
        .avatar-upload .avatar-edit input + label:after {
            content: "\f040";
            font-family: 'FontAwesome';
            color: #757575;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
        }
        .avatar-upload .avatar-preview {

            position: relative;

            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }
        .avatar-upload .avatar-preview > div {
            width: auto;
            height: 270px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

    </style>
@stop
@section('content')
    <div class="block-header">
        <h2>Link List</h2>
    </div>

    <!-- Static Table Start -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul class="nav nav-tabs custom-menu-wrap custon-tab-menu-style1">
                <li class="active"><a data-toggle="tab" href="#table_div"><span class="edu-icon edu-analytics tab-custon-ic"></span>View</a>
                </li>
                <li><a data-toggle="tab" href="#form_div"><span class="edu-icon edu-analytics-arrow tab-custon-ic"></span>New Link</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="table_div" class="tab-pane in active animated flipInX custon-tab-style1">
                    <!-- Form Name -->

                    <div class="card">
                        <div class="header">Link List</div>
                        <div class="body">
                            @foreach($data as $item)

                                <form class="form-horizontal" method="post" action="{{route('admin.edit_link')}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <fieldset>
                                        <input type='hidden' name="id" value="{{$item->id}}"/>

                                        <div class="row">
                                            <div class="col-md-12">
                                                {{--Image--}}
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="textinput">Link Image</label>
                                                    <div class="col-md-9" style="border-radius: 20px">
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' id="link_image_{{$item->id}}" name="link_image" class="input_image" accept=".png, .jpg, .jpeg" />
                                                                <label for="link_image_{{$item->id}}"></label>
                                                            </div>
                                                            <div class="avatar-preview">
                                                                <div id="link_image_{{$item->id}}Preview" style="background-image: url({{asset('img/link/'.$item->img)}});">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--<div class="tinymce-single description{{$item->id}}">
                                                    <div class="alert-title" style="display: flex">
                                                        <h2>Description</h2>
                                                        <div class="form-group" style="flex: 1">
                                                            <div class="col-md-12" style="text-align: right;">
                                                                <button type="button" name="submit" class="btn btn-primary" onclick="setDescription('description{{$item->id}}','input_description{{$item->id}}')">save description</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input id="input_description{{$item->id}}" name="description" type="hidden" value="{{$item->description}} " class="form-control">
                                                    <div id="summernote{{$item->id}}">
                                                        @php( print_r($item->description))
                                                    </div>

                                                </div>--}}
                                            </div>
                                            <div class="col-md-6">
                                                {{--link--}}
                                                <div class="form-group">
                                                    {{--<label class="col-md-3 control-label" for="textinput">Link</label>--}}
                                                    <div class="form-line">
                                                        <input name="link" type="text" placeholder="Link" class="form-control input-md" value="{{$item->link}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{--link_name--}}
                                                <div class="form-group">
                                                    {{--<label class="col-md-3 control-label" for="textinput">Name</label>--}}
                                                    <div class="form-line">
                                                        <input id="name" name="name" type="text" placeholder="Name" class="form-control input-md" value="{{$item->name}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{--link content--}}
                                                <div class="form-group">
                                                    {{-- <label class="col-md-3 control-label" for="textinput">Content</label>--}}
                                                    <div class="form-line">
                                                        <input id="content" name="content" type="text" placeholder="Content" class="form-control input-md" value="{{$item->content}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- active -->
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="selectbasic">Active</label>
                                                    <div class="col-md-9">
                                                        <select id="is_active" name="is_active" class="form-control show-tick">
                                                            <option value="true" {{$item->is_active == 'true'?'selected':''}}>Yes</option>
                                                            <option value="false" {{$item->is_active == 'true'?'':'selected'}}>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div style="text-align: center;">
                                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div style="text-align: center;">
                                                    <a href="#"  class="btn btn-danger">Delete</a>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </form>
                                <legend></legend>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="form_div" class="tab-pane animated flipInX custon-tab-style1">
                    <div class="card">
                        <div class="header">New Link</div>
                        <div class="body">
                            <form class="form-horizontal" method="post" action="{{route('admin.add_link')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <fieldset>
                                    <!-- Form Name -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{--Image--}}
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="textinput">Link Image</label>
                                                <div class="col-md-9" style="border-radius: 20px">
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' id="link_image" name="link_image" class="input_image" accept=".png, .jpg, .jpeg" />
                                                            <label for="link_image"></label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="link_imagePreview">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            {{--link--}}
                                            <div class="form-group">
                                                {{--<label class="col-md-3 control-label" for="textinput">Link</label>--}}
                                                <div class="form-line">
                                                    <input id="link" name="link" type="text" placeholder="Link" class="form-control input-md" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{--link_name--}}
                                            <div class="form-group">
                                                {{-- <label class="col-md-3 control-label" for="textinput">Name</label>--}}
                                                <div class="form-line">
                                                    <input id="name" name="name" type="text" placeholder="Name" class="form-control input-md" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{--link content--}}
                                            <div class="form-group">
                                                {{--<label class="col-md-3 control-label" for="textinput">Content</label>--}}
                                                <div class="form-line">
                                                    <input id="content" name="content" type="text" placeholder="Content" class="form-control input-md" value="">
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="col-md-6">
                                            <!-- link description -->
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="selectbasic">Login</label>
                                                <div class="col-md-9">
                                                    <select id="login" name="login" class="form-control">
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>--}}


                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12" style="text-align: center">{{isset($msg)?$msg:''}}</label>
                                    </div>
                                    <!-- Button -->
                                    <div class="form-group">
                                        <div class="col-md-12" style="text-align: center;">
                                            <button id="submit" type="submit" name="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>

                                </fieldset>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('script')
    <script src="{{asset('user/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>


    <script>
        function readURL(input) {
            //alert("asdf");
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#'+input.id+'Preview').css('background-image', 'url('+e.target.result +')');
                    //alert(e.target.result);
                    $('#'+input.id+'Preview').hide();
                    $('#'+input.id+'Preview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".input_image").change(function() {
            //alert("asdf");
            //console.log(this.id);
            readURL(this);
        });
    </script>
    <script>
        function setDescription(editor_id,input_id) {
            var description=$('.'+editor_id+' .panel-body').html();
            $('#'+input_id).val(description);
            //console.log(rules);
        }
    </script>
@stop
