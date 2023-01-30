@extends('admin.layout.main')
@section('title', __("str.Edit Product"))
@section('description',__("str.Edit Product"))
@section('author',__("str.Edit Product"))
@section('keywords',__("str.Edit Product"))
@section('copyright',__("str.Edit Product"))
@section('css')
@endsection
{{--@php
    $lang = config('app.locale');
    $path = asset("uploads/products/".$product->image);
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $product_image = 'data:image/' . $type . ';base64,' . base64_encode($data);
@endphp--}}
@section('content')
    <!--begin::Content-->

    <input type="hidden" id="item_id" value="{{$product->id}}">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                     data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                     class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{__("str.Product Form")}}</h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{url("/admin/products")}}"
                               class="text-muted text-hover-primary">{{__("str.Products")}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__("str.Edit Product")}}</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Filter menu-->
                    <div class="m-0">
                        <!--begin::Menu toggle-->
                        <!--end::Menu toggle-->
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                             id="kt_menu_61de0bb73a042">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bolder">{{__("str.Filter Options")}}</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Menu separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Menu separator-->
                            <!--begin::Form-->
                            <div class="px-7 py-5">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bold">{{__("str.Status:")}}</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div>
                                        <select class="form-select form-select-solid" data-kt-select2="true"
                                                data-placeholder="{{__("str.Select option")}}"
                                                data-dropdown-parent="#kt_menu_61de0bb73a042" data-allow-clear="true">
                                            <option></option>
                                            <option value="1">{{__("str.Approved")}}</option>
                                            <option value="2">{{__("str.Pending")}}</option>
                                            <option value="2">{{__("str.In Process")}}</option>
                                            <option value="2">{{__("str.Rejected")}}</option>
                                        </select>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bold">{{__("str.Member Type:")}}</label>
                                    <!--end::Label-->
                                    <!--begin::Options-->
                                    <div class="d-flex">
                                        <!--begin::Options-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="checkbox" value="1"/>
                                            <span class="form-check-label">{{__("str.Author")}}</span>
                                        </label>
                                        <!--end::Options-->
                                        <!--begin::Options-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="2"
                                                   checked="checked"/>
                                            <span class="form-check-label">{{__("str.Customer")}}</span>
                                        </label>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Options-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bold">{{__("str.Notifications:")}}</label>
                                    <!--end::Label-->
                                    <!--begin::Switch-->
                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="" name="notifications"
                                               checked="checked"/>
                                        <label class="form-check-label">{{__("str.Enabled")}}</label>
                                    </div>
                                    <!--end::Switch-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                            data-kt-menu-dismiss="true">{{__("str.Reset")}}
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">
                                        {{__("str.Apply")}}
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Form-->
                        </div>
                        <!--end::Menu 1-->
                    </div>
                    <!--end::Filter menu-->
                    <!--begin::Secondary button-->
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->

                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Form-->
                <div id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row"
                     data-kt-redirect="">
                    <!--begin::Aside column-->
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>{{__("str.Thumbnail")}}</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <div class="image-input image-input-empty image-input-outline mb-3"
                                     data-kt-image-input="true"
                                     style="background-image: url({{assert("assets/admin/images/blank-image.svg")}})">
                                    <!--begin::Preview existing avatar-->
                                    <div id="uploaded_image" class="image-input-wrapper w-150px h-150px"
                                         style="background-image: url({{asset("uploads/products/".$product->image)}})"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                           data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                           title="{{__("str.Change avatar")}}">
                                        <!--begin::Icon-->
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <!--end::Icon-->
                                        <!--begin::Inputs-->
                                        <input id="image_file_input" type="file" name="avatar"
                                               accept=".png, .jpg, .jpeg"/>

                                        <input type="hidden" name="avatar_remove"/>
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                          data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                          title="{{__("str.Cancel avatar")}}">
														<i class="bi bi-x fs-2"></i>
													</span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                          data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                          title="{{__("str.Remove avatar")}}">
														<i class="bi bi-x fs-2"></i>
													</span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Description-->
                                <div>
                                    <strong id="product_image_error" class="errors text-danger fs-7"></strong>
                                </div>
                                <div class="required text-muted fs-7">{{__("str.Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted and size 1M")}}
                                </div>
                                <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->
                        <!--begin::Status-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>{{__("str.Status")}}</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <div class="rounded-circle bg-success w-15px h-15px {{$product->status ==  1 ? "bg-success": "bg-danger"}}"
                                         id="kt_ecommerce_add_product_status"></div>
                                </div>
                                <!--begin::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Select2-->
                                <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                        data-placeholder="{{__("str.Select an option")}}"
                                        id="kt_ecommerce_add_product_status_select">
                                    <option></option>
                                    <option value="published" {{$product->status ==  1 ? "selected": ""}}>{{__("str.Published")}}</option>
                                    <!--                                    <option value="scheduled">Scheduled</option>-->
                                    <option value="unpublished" {{$product->status ==  0 ? "selected": ""}}>{{__("str.Unpublished")}}</option>
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">{{__("str.Set the product status.")}}</div>
                                <!--end::Description-->
                                <!--begin::Datepicker-->
                                <div class="d-none mt-10">
                                    <label for="kt_ecommerce_add_product_status_datepicker"
                                           class="form-label">{{__("str.Select publishing date and time")}}</label>
                                    <input class="form-control" id="kt_ecommerce_add_product_status_datepicker"
                                           placeholder="{{__("str.Pick date and time")}}"/>
                                </div>
                                <!--end::Datepicker-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Status-->
                        <!--begin::Product & tags-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>{{__("str.Product Details")}}</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Input group-->
                                <!--begin::Label-->
                                <label class="form-label">{{__("str.Categories")}}</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select id="product_categories" class="form-select mb-2" data-control="select2"
                                        data-placeholder="{{__("str.Select an option")}}" data-allow-clear="true"
                                        multiple="multiple">
                                    @foreach($categories as $category)
                                        <option @foreach($product->categories as $product_category)
                                                {{$product_category->category_fk_id ==  $category->id ? "selected": ""}}
                                                @endforeach
                                                value="{{$category->id}}">{{$category->getTranslation('name',config('app.locale'))}}</option>
                                    @endforeach
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7 mb-7">{{__("str.Add product to a category.")}}</div>
                                <!--end::Description-->
                                <!--end::Input group-->
                                <!--begin::Button-->
                                <a href="{{url("/admin/categories/create")}}"
                                   class="btn btn-light-primary btn-sm mb-10">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                    <span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1"
                                                              transform="rotate(-90 11 18)" fill="black"/>
														<rect x="6" y="11" width="12" height="2" rx="1" fill="black"/>
													</svg>
									</span>
                                    <!--end::Svg Icon-->
                                    {{__("str.Create new category")}}
                                </a>
                                <!--end::Button-->
                                <!--end::Description-->
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Product & tags-->
                        <!--begin::Weekly sales-->
                        <!--end::Weekly sales-->
                        <!--begin::Template settings-->
                        <!--end::Template settings-->
                    </div>
                    <!--end::Aside column-->
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin:::Tabs-->
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a id="general_tap" class="nav-link text-active-primary pb-4 active"
                                   data-bs-toggle="tab"
                                   href="#kt_ecommerce_add_product_general">{{__("str.General")}}</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a id="advanced_tap" class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                   href="#kt_ecommerce_add_product_advanced">{{__("str.Advanced")}}</a>
                            </li>
                            <!--end:::Tab item-->
                        </ul>
                        <!--end:::Tabs-->
                        <!--begin::Tab content-->
                        <div id="top_content" class="tab-content">
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general"
                                 role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <!--begin::General options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{__("str.General")}}</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__("str.Product Name (Arabic)")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input id="product_name" type="text" name="product_name"
                                                       class="form-control mb-2"
                                                       placeholder="{{__("str.Product name")}}"
                                                       value="{{$product->getTranslation("name","ar")}}"/>
                                                <!--end::Input-->
                                                <!--begin::Error-->
                                                <strong id="product_name_error"
                                                        class="errors text-danger fs-7"></strong>
                                                <!--end::Error-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.A product name is required and recommended to be  unique.")}}</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__("str.Product Name (English)")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input id="product_name_en" type="text" name="product_name_en"
                                                       class="form-control mb-2"
                                                       placeholder="{{__("str.Product name")}}"
                                                       value="{{$product->getTranslation("name","en")}}"/>
                                                <!--end::Input-->
                                                <!--begin::Error-->
                                                <strong id="product_name_en_error"
                                                        class="errors text-danger fs-7"></strong>
                                                <!--end::Error-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.A product name is required and recommended to be unique.")}}</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">{{__("str.Description (Arabic)")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <textarea id=""
                                                          class="ckeditor_textarea form-control mb-2">{{$product->getTranslation("description","ar")}}</textarea>
                                                <input id="product_description" type="hidden"
                                                       class="ckeditor_value form-control mb-2"
                                                       value="{{$product->getTranslation("description","ar")}}">
                                                <!--end::Editor-->
                                                <!--begin::Error-->
                                                <strong id="product_description_error"
                                                        class="errors text-danger fs-7"></strong>
                                                <!--end::Error-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.Set a description to the product for better visibility.")}}
                                                </div>
                                                <div id="back_here"></div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">{{__("str.Description (English)")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <textarea id=""
                                                          class="ckeditor_textarea_en form-control mb-2">{{$product->getTranslation("description","en")}}</textarea>
                                                <input id="product_description_en" type="hidden"
                                                       class="ckeditor_value_en form-control mb-2"
                                                       value="{{$product->getTranslation("description","en")}}">
                                                <!--end::Editor-->
                                                <!--begin::Error-->
                                                <strong id="product_description_en_error"
                                                        class="errors text-danger fs-7"></strong>
                                                <!--end::Error-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.Set a description to the product for better visibility.")}}
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::General options-->
                                    <!--begin::Media-->
                                    <div id="media" class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{__("str.Media")}}</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--start::Old media-->
                                        @foreach($product->media as $media)
                                            <input data-id="{{$media->id}}" data-name="{{$media->media}}"
                                                   class="old_media"
                                                   value="{{asset("uploads/products/")."/".$media->media}}"
                                                   type="hidden">
                                    @endforeach
                                    <!--end::Old media-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group box upload image-->
                                            <div class="fv-row mb-2">
                                                <!--begin::Dropzone-->
                                                <div class="dropzone" id="kt_ecommerce_add_product_media">
                                                    <!--begin::Message-->
                                                    <div class="dz-message needsclick">
                                                        <!--begin::Icon-->
                                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                        <!--end::Icon-->
                                                        <!--begin::Info-->
                                                        <div class="ms-4">
                                                            <h3 class="fs-5 fw-bolder text-gray-900 mb-1">{{__("str.Drop files here or click to upload.")}}</h3>
                                                            <span class="fs-7 fw-bold text-gray-400">{{__("str.Upload down to 6 files")}}</span>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                </div>
                                                <!--end::Dropzone-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Error-->
                                            <strong id="product_media_error"
                                                    class="errors text-danger fs-7"></strong>
                                            <!--end::Error-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">{{__("str.Set the product media gallery.")}}</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Media-->
                                    <!--begin::Pricing-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{__("str.Pricing")}}</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__("str.Base Price")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input id="product_price" type="number" name="price"
                                                       class="text-start form-control mb-2"
                                                       placeholder="{{__("str.Product price")}}"
                                                       value="{{$product->price}}"/>
                                                <!--end::Input-->
                                                <!--begin::Error-->
                                                <strong id="product_price_error"
                                                        class="errors text-danger fs-7"></strong>
                                                <!--end::Error-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.Set the product price.")}}</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                        <!--                                            <div class="fv-row mb-10">
                                                &lt;!&ndash;begin::Label&ndash;&gt;
                                                <label class="fs-6 fw-bold mb-2">{{__("str.Discount Type")}}
                                                <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                   data-bs-toggle="tooltip"
                                                   title="{{__("str.Select a discount type that will be applied to this product")}}"></i></label>
                                                &lt;!&ndash;End::Label&ndash;&gt;
                                                &lt;!&ndash;begin::Row&ndash;&gt;
                                                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 row-cols-xl-3 g-9"
                                                     data-kt-buttons="true"
                                                     data-kt-buttons-target="[data-kt-button='true']">
                                                    &lt;!&ndash;begin::Col&ndash;&gt;
                                                    <div class="col">
                                                        &lt;!&ndash;begin::Option&ndash;&gt;
                                                        <label class="btn btn-outline btn-outline-dashed btn-outline-default
                                                         d-flex text-start p-6 {{$product->discount ? $product->discount->type == 0 ? "active": "" :"active"}}"
                                                               data-kt-button="true">
                                                            &lt;!&ndash;begin::Radio&ndash;&gt;
                                                            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																				<input class="form-check-input"
                                                                                       type="radio"
                                                                                       name="discount_option" value="1"
                                                                                       {{$product->discount ? $product->discount->type == 0 ? "checked": "":"checked"}}/>
																			</span>
                                                            &lt;!&ndash;end::Radio&ndash;&gt;
                                                            &lt;!&ndash;begin::Info&ndash;&gt;
                                                            <span class="ms-5">
																				<span class="fs-4 fw-bolder text-gray-800 d-block">{{__("str.No Discount")}}</span>
																			</span>
                                                            &lt;!&ndash;end::Info&ndash;&gt;
                                                        </label>
                                                        &lt;!&ndash;end::Option&ndash;&gt;
                                                    </div>
                                                    &lt;!&ndash;end::Col&ndash;&gt;
                                                    &lt;!&ndash;begin::Col&ndash;&gt;
                                                    <div class="col">
                                                        &lt;!&ndash;begin::Option&ndash;&gt;
                                                        <label class="btn btn-outline btn-outline-dashed btn-outline-default
                                                         d-flex text-start p-6 {{$product->discount ? $product->discount->type == 1 ? "active": "":""}}"
                                                               data-kt-button="true">
                                                            &lt;!&ndash;begin::Radio&ndash;&gt;
                                                            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																				<input class="form-check-input"
                                                                                       type="radio"
                                                                                       name="discount_option"
                                                                                       value="2" {{$product->discount ? $product->discount->type == 1 ? "checked": "":""}}/>
																			</span>
                                                            &lt;!&ndash;end::Radio&ndash;&gt;
                                                            &lt;!&ndash;begin::Info&ndash;&gt;
                                                            <span class="ms-5">
																				<span class="fs-4 fw-bolder text-gray-800 d-block">{{__("str.Percentage %")}}</span>
																			</span>
                                                            &lt;!&ndash;end::Info&ndash;&gt;
                                                        </label>
                                                        &lt;!&ndash;end::Option&ndash;&gt;
                                                    </div>
                                                    &lt;!&ndash;end::Col&ndash;&gt;
                                                    &lt;!&ndash;begin::Col&ndash;&gt;
                                                    <div class="col">
                                                        &lt;!&ndash;begin::Option&ndash;&gt;
                                                        <label class="btn btn-outline btn-outline-dashed btn-outline-default
                                                         d-flex text-start p-6 {{$product->discount ? $product->discount->type == 2 ? "active": "":""}}"
                                                               data-kt-button="true">
                                                            &lt;!&ndash;begin::Radio&ndash;&gt;
                                                            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																				<input class="form-check-input"
                                                                                       type="radio"
                                                                                       name="discount_option"
                                                                                       value="3" {{$product->discount ? $product->discount->type == 2 ? "checked": "":""}}/>
																			</span>
                                                            &lt;!&ndash;end::Radio&ndash;&gt;
                                                            &lt;!&ndash;begin::Info&ndash;&gt;
                                                            <span class="ms-5">
																				<span class="fs-4 fw-bolder text-gray-800 d-block">{{__("str.Fixed Price")}}</span>
																			</span>
                                                            &lt;!&ndash;end::Info&ndash;&gt;
                                                        </label>
                                                        &lt;!&ndash;end::Option&ndash;&gt;
                                                    </div>
                                                    &lt;!&ndash;end::Col&ndash;&gt;
                                                </div>
                                                &lt;!&ndash;end::Row&ndash;&gt;
                                            </div>
                                            &lt;!&ndash;end::Input group&ndash;&gt;
                                            &lt;!&ndash;begin::Input group&ndash;&gt;
                                            <div class="{{$product->discount ? $product->discount->type == 1 ? "": "d-none":"d-none"}} mb-10 fv-row"
                                                 id="kt_ecommerce_add_product_discount_percentage">
                                                &lt;!&ndash;begin::Label&ndash;&gt;
                                                <label class="form-label">{{__("str.Set Discount Percentage")}}</label>
                                                &lt;!&ndash;end::Label&ndash;&gt;
                                                &lt;!&ndash;begin::Slider&ndash;&gt;
                                                <div class="d-flex flex-column text-center mb-5">
                                                    <div class="d-flex align-items-start justify-content-center mb-7">
                                                        <span class="fw-bolder fs-3x"
                                                              id="kt_ecommerce_add_product_discount_label">{{$product->discount ? $product->discount->type == 1 ? $product->discount->value: 1: 1}}</span>
                                                        <span class="fw-bolder fs-4 mt-1 ms-2">%</span>
                                                    </div>
                                                    <div id="kt_ecommerce_add_product_discount_slider"
                                                         class="noUi-sm"></div>
                                                </div>
                                                &lt;!&ndash;end::Slider&ndash;&gt;
                                                &lt;!&ndash;begin::Description&ndash;&gt;
                                                <div class="text-muted fs-7">{{__("str.Set a percentage discount to be applied on this product.")}}
                                                </div>
                                                &lt;!&ndash;end::Description&ndash;&gt;
                                            </div>
                                            &lt;!&ndash;end::Input group&ndash;&gt;
                                            &lt;!&ndash;begin::Input group&ndash;&gt;
                                            <div class="{{$product->discount ? $product->discount->type == 2 ? "": "d-none":"d-none"}} mb-10 fv-row"
                                                 id="kt_ecommerce_add_product_discount_fixed">
                                                &lt;!&ndash;begin::Label&ndash;&gt;
                                                <label class="form-label">{{__("str.Fixed Discounted Price")}}</label>
                                                &lt;!&ndash;end::Label&ndash;&gt;
                                                &lt;!&ndash;begin::Input&ndash;&gt;
                                                <input id="product_discount_fixed" type="number" name="dicsounted_price"
                                                       class="form-control mb-2"
                                                       placeholder="{{__("str.Discounted price")}}"
                                                       value="{{$product->discount ? $product->discount->type == 2 ? $product->discount->value: "":""}}"/>
                                                &lt;!&ndash;end::Input&ndash;&gt;
                                                &lt;!&ndash;begin::Description&ndash;&gt;
                                                <div class="text-muted fs-7">{{__("str.Set the discounted product price. The product will be reduced at the determined fixed price")}}</div>
                                                &lt;!&ndash;end::Description&ndash;&gt;
                                            </div>-->
                                            <!--end::Input group-->
                                            <!--begin::Tax-->

                                            <!--end:Tax-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Pricing-->
                                </div>
                            </div>
                            <!--end::Tab pane-->
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <!--begin::Inventory-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{__("str.Inventory")}}</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__("str.Quantity")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="d-flex gap-3">
                                                    <input id="product_quantity" type="number" name="shelf"
                                                           class="text-start form-control mb-2"
                                                           placeholder="{{__("str.On shelf")}}"
                                                           value="{{$product->quantity}}"/>
                                                    <!--                                                    <input type="number" name="warehouse" class="form-control mb-2"
                                                                                                               placeholder="In warehouse"/>-->
                                                </div>
                                                <!--end::Input-->
                                                <!--begin::Error-->
                                                <strong id="product_quantity_error"
                                                        class="errors text-danger fs-7"></strong>
                                                <!--end::Error-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.Enter the product quantity.")}}</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Inventory-->
                                    <!--begin::Variations-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{__("str.Variations")}}</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="" data-kt-ecommerce-catalog-add-product="auto-options">
                                                <!--begin::Label-->
                                                <label class="form-label">{{__("str.Edit Product Variations")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Repeater-->
                                                <div id="kt_ecommerce_add_product_options">
                                                    <!--begin::Form group-->
                                                    <div class="form-group">
                                                        <div data-repeater-list="kt_ecommerce_add_product_options"
                                                             class="d-flex flex-column gap-3">
                                                            <div data-repeater-item=""
                                                                 class="variation_item form-group d-flex flex-wrap gap-5">
                                                                <input class="variation_id" value="" type="hidden">
                                                                <!--begin::Select2-->
                                                                <!--begin::Input-->
                                                                <input type="text"
                                                                       class="variation_name form-control mw-200 w-225px"
                                                                       name="kt_ecommerce_add_product_options[0][product_option_value]"
                                                                       placeholder="{{__("str.Variation Name (Arabic)")}}">
                                                                <!--end::Input-->
                                                                <!--begin::Input-->
                                                                <input type="text"
                                                                       class="variation_name_en form-control mw-200 w-225px"
                                                                       name="kt_ecommerce_add_product_options[0][product_option_value]"
                                                                       placeholder="{{__("str.Variation Name (English)")}}">
                                                                <!--end::Input-->
                                                                <!--end::Select2-->
                                                                <!--begin::Input-->
                                                                <input type="number"
                                                                       class="text-start variation_price form-control mw-80 w-100px"
                                                                       name="kt_ecommerce_add_product_options[0][product_option_value]"
                                                                       placeholder="{{__("str.Price")}}">
                                                                <!--end::Input-->
                                                                <button type="button" data-repeater-delete=""
                                                                        class="variation_delete btn btn-sm btn-icon btn-light-danger">
                                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                                    <span class="svg-icon svg-icon-2">
																						<svg xmlns="http://www.w3.org/2000/svg"
                                                                                             width="24" height="24"
                                                                                             viewBox="0 0 24 24"
                                                                                             fill="none">
																							<rect opacity="0.5"
                                                                                                  x="7.05025"
                                                                                                  y="15.5356" width="12"
                                                                                                  height="2" rx="1"
                                                                                                  transform="rotate(-45 7.05025 15.5356)"
                                                                                                  fill="black"></rect>
																							<rect x="8.46447"
                                                                                                  y="7.05029" width="12"
                                                                                                  height="2" rx="1"
                                                                                                  transform="rotate(45 8.46447 7.05029)"
                                                                                                  fill="black"></rect>
																						</svg>
																					</span>
                                                                    <!--end::Svg Icon-->
                                                                </button>
                                                            </div>
                                                            <!--start::Error-->
                                                            <strong id="variation_error"
                                                                    class="errors text-danger fs-7"></strong>
                                                            <!--end::Error-->
                                                            @php
                                                                $count = -1;
                                                            @endphp
                                                            @foreach($product->options as $option)
                                                                @php
                                                                    $count++;
                                                                @endphp
                                                                <div data-repeater-item=""
                                                                     class="variation_item form-group d-flex flex-wrap gap-5">
                                                                    <!--begin::Select2-->
                                                                    <input class="variation_id" value="{{$option->id}}"
                                                                           type="hidden">
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                           class="variation_name form-control mw-200 w-225px"
                                                                           name="kt_ecommerce_add_product_options[{{$count}}][product_option_value]"
                                                                           placeholder="{{__("str.Variation Name (Arabic)")}}"
                                                                           data-id="{{$option->id}}"
                                                                           value="{{$option->getTranslation("name","ar")}}">
                                                                    <!--end::Input-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                           class="variation_name_en form-control mw-200 w-225px"
                                                                           name="kt_ecommerce_add_product_options[{{$count}}][product_option_value]"
                                                                           placeholder="{{__("str.Variation Name (English)")}}"
                                                                           data-id="{{$option->id}}"
                                                                           value="{{$option->getTranslation("name","en")}}">
                                                                    <!--end::Input-->
                                                                    <!--end::Select2-->
                                                                    <!--begin::Input-->
                                                                    <input type="number"
                                                                           class="text-start variation_price form-control mw-80 w-100px"
                                                                           name="kt_ecommerce_add_product_options[{{$count}}][product_option_value]"
                                                                           placeholder="{{__("str.Price")}}"
                                                                           data-id="{{$option->id}}"
                                                                           value="{{$option->price}}">
                                                                    <!--end::Input-->
                                                                    <button type="button" data-repeater-delete=""
                                                                            data-id="{{$option->id}}"
                                                                            class="variation_delete btn btn-sm btn-icon btn-light-danger">
                                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                                        <span class="svg-icon svg-icon-2">
																						<svg xmlns="http://www.w3.org/2000/svg"
                                                                                             width="24" height="24"
                                                                                             viewBox="0 0 24 24"
                                                                                             fill="none">
																							<rect opacity="0.5"
                                                                                                  x="7.05025"
                                                                                                  y="15.5356" width="12"
                                                                                                  height="2" rx="1"
                                                                                                  transform="rotate(-45 7.05025 15.5356)"
                                                                                                  fill="black"></rect>
																							<rect x="8.46447"
                                                                                                  y="7.05029" width="12"
                                                                                                  height="2" rx="1"
                                                                                                  transform="rotate(45 8.46447 7.05029)"
                                                                                                  fill="black"></rect>
																						</svg>
																					</span>
                                                                        <!--end::Svg Icon-->
                                                                    </button>
                                                                </div>
                                                                <!--start::Error-->
                                                                <strong id="variation_error"
                                                                        class="errors text-danger fs-7"></strong>
                                                                <!--end::Error-->

                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <!--end::Form group-->
                                                    <!--begin::Form group-->
                                                    <div class="form-group mt-5">
                                                        <button type="button" data-repeater-create
                                                                class="btn btn-sm btn-light-primary">
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                                            <span class="svg-icon svg-icon-2">
																			<svg xmlns="http://www.w3.org/2000/svg"
                                                                                 width="24" height="24"
                                                                                 viewBox="0 0 24 24" fill="none">
																				<rect opacity="0.5" x="11" y="18"
                                                                                      width="12" height="2" rx="1"
                                                                                      transform="rotate(-90 11 18)"
                                                                                      fill="black"></rect>
																				<rect x="6" y="11" width="12" height="2"
                                                                                      rx="1" fill="black"></rect>
																			</svg>
																		</span>
                                                            <!--end::Svg Icon-->{{__("str.Edit another variation")}}
                                                        </button>
                                                    </div>
                                                    <!--end::Form group-->
                                                </div>
                                                <!--end::Repeater-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Variations-->
                                    <!--begin::Shipping-->
                                    <!--end::Shipping-->
                                    <!--begin::Meta options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{__("str.Meta Options")}}</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label">{{__("str.Meta Tag Title (Arabic)")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input id="meta_title" type="text" class="form-control mb-2"
                                                       name="meta_title"
                                                       placeholder="{{__("str.Meta tag name")}}"
                                                       data-id="{{$product->meta ? $product->meta->id: ""}}"
                                                       value="{{$product->meta ? $product->meta->getTranslation("meta_title","ar"): ""}}"/>
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.Set a meta tag title. Recommended to be simple and precise keywords.")}}
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label">{{__("str.Meta Tag Title (English)")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input id="meta_title_en" type="text" class="form-control mb-2"
                                                       name="meta_title"
                                                       placeholder="{{__("str.Meta tag name")}}"
                                                       data-id="{{$product->meta ? $product->meta->id: ""}}"
                                                       value="{{$product->meta ? $product->meta->getTranslation("meta_title","en"): ""}}"/>
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.Set a meta tag title. Recommended to be simple and precise keywords.")}}
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label">{{__("str.Meta Tag Description (Arabic)")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <input id="meta_description" type="text" class="form-control mb-2"
                                                       name="meta_title"
                                                       placeholder="{{__("str.Meta tag Description")}}"
                                                       data-id="{{$product->meta ? $product->meta->id: ""}}"
                                                       value="{{$product->meta ? $product->meta->getTranslation("meta_description","ar"): ""}}"/>
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.Set a meta tag description to the product for increased SEO ranking.")}}
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label">{{__("str.Meta Tag Description (English)")}}</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <input id="meta_description_en" type="text" class="form-control mb-2"
                                                       name="meta_title"
                                                       placeholder="{{__("str.Meta tag Description")}}"
                                                       data-id="{{$product->meta ? $product->meta->id: ""}}"
                                                       value="{{$product->meta ? $product->meta->getTranslation("meta_description","en"): ""}}"/>
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">{{__("str.Set a meta tag description to the product for increased SEO ranking.")}}
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Meta options-->
                                </div>
                            </div>
                            <!--end::Tab pane-->
                        </div>
                        <!--end::Tab content-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ url()->previous() }}"
                               id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__("str.Cancel")}}</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                                <span class="indicator-label">{{__("str.Save Changes")}}</span>
                                <span class="indicator-progress">{{__("str.Please wait...")}}
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
@endsection
@section('js')
    <script src="{{ asset('ckeditor_v5/ckeditor.js') }}" defer></script>
    <script src="{{ asset('assets/js/ckeditor.js') }}" defer></script>
    <script src="{{ asset('assets/js/product/edit_product.js') }}" defer></script>
@endsection
