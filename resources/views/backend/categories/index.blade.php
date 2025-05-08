@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    {{-- <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('All Categories')}}</h1>
        </div>
        @can('add_product_category')
            <div class="col-md-6 text-md-right">
                <a href="{{ route('categories.create') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Add New category')}}</span>
                </a>
            </div>
        @endcan
    </div> --}}
</div>
<div class="card">
    <div class="card-header d-block d-md-flex">
        <h5 class="mb-0 h6">{{ translate('Categories') }}</h5>
        <form class="" id="sort_categories" action="" method="GET">
            <div class="box-inline pad-rgt pull-left">
                <div class="" style="min-width: 200px;">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Image')}}</th>
                    <th>{{translate('Name')}}</th>
                    <th>{{ translate('Parent Category') }}</th>
                    <th>{{translate('Top')}}</th>
                    <th>{{translate('Show')}}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $key => $category)
             
                    <tr>
                        <td>{{ ($key+1) + ($categories->currentPage() - 1)*$categories->perPage() }}</td>
                        <td>
                            @if($category->banner != null)
                                <img src="{{ uploaded_asset($category->banner) }}" alt="{{translate('Banner')}}" class="h-50px">
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            {{ $category->CustomName }}
                        </td>
                        <td>
                            {{ $category->parentCategory ? $category->parentCategory->CustomName : translate('N/A') }}
                        </td>
                        
                        <td>
                            @if($category->ParentId == NULL && $category->IsShow ==1 )
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="top_category(this)" data-categoryId="{{$category->CategoryId}}" data-id="{{ $category->id }}" @if($category->is_top == 1) checked @endif>
                                <span></span>
                            </label>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="status_change(this)" data-categoryId="{{$category->CategoryId}}" data-id="{{ $category->id }}" @if($category->IsShow == 1) checked @endif>
                                <span></span>
                            </label>
                        </td>
                        <td class="text-right">
                            @can('edit_product_category')
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('categories.edit', ['id'=>$category->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            @endcan
                            @can('delete_product_category')
                                <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('categories.destroy', $category->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $categories->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection


@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script>
        function status_change(element) {
            const categoryId = $(element).data('categoryid');
            const id = $(element).data('id');
            const status = element.checked ? 1 : 0;
            
            $.ajax({
                url: "{{ route('categories.status_change') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    categoryId: categoryId,
                    status: status
                },
                success: function(response) {
                    if(response.success){
                        AIZ.plugins.notify('success', '{{ translate('Status updated successfully') }}');
                        location.reload();
                    }
                    else{
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                },
                error: function(xhr) {
                    alert("An error occurred while updating the status.");
                }
            });
        }
        function top_category(element) {
            const categoryId = $(element).data('categoryid');
            const id = $(element).data('id');
            const status = element.checked ? 1 : 0;
            
            $.ajax({
                url: "{{ route('categories.top_category') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    categoryId: categoryId,
                    status: status
                },
                success: function(response) {
                    if(response.success){
                        AIZ.plugins.notify('success', '{{ translate('Top category updated successfully') }}');
                        location.reload();
                    }
                    else{
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                },
                error: function(xhr) {
                    alert("An error occurred while updating the status.");
                }
            });
        }
    </script>
@endsection
