@extends('admin.layouts.default')

@section('pageTitle', $pageTitle)

@section('additionalStyles')
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $pageTitle }}</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="data-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        @if(isset($createRoute))
                            <a href="{{ route($createRoute) }}" class="btn btn-success pull-left">+ Add {{ str_singular($pageTitle) }}</a>
                        @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data-table" class="table table-bordered table-striped dataTable" role="grid"
                                       aria-describedby="data-table_info">
                                    <thead>
                                    <tr>
                                        @foreach($model->adminTableColumns() as $col)
                                            <th class="{{ array_get($col, 'type') }}">{{ $col['name'] }}</th>
                                        @endforeach
                                        <th class="no-sort">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="sortable" data-entityname="{{ strtolower($pageTitle) }}">
                                        @forelse ($records as $record)
                                            <tr data-itemId="{{{ $record->id }}}">
                                                @foreach($model->adminTableColumns() as $col)
                                                    <td data-order="{{ $record->$col['db_field'] }}">
                                                        {!! $model->renderTableRow($record, $col) !!}
                                                    </td>
                                                @endforeach
                                                <td>
                                                    @if(isset($editRoute))
                                                        <a href="{{ route($editRoute, ['id' => $record->id]) }}"
                                                           class="btn btn-primary">
                                                            Edit
                                                        </a>
                                                    @endif

                                                    @if(isset($showRoute))
                                                        <a href="{{ route($showRoute, ['id' => $record->id]) }}"
                                                           class="btn btn-primary">
                                                            Show
                                                        </a>
                                                    @endif

                                                    @if(isset($deleteRoute))
                                                    <a href="#"
                                                        {{-- data-toggle="modal" data-target="#delete-modal" --}}
                                                        class="js-open-delete-modal btn btn-danger"
                                                        data-record="{{ json_encode($record->toArray()) }}"
                                                        data-delete-url="{{ route($deleteRoute, ['id' => $record->id]) }}">
                                                        Delete
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                @foreach($model->adminTableColumns() as $key => $col)
                                                    @if($key == 0)
                                                        <td>No Data</td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                                @endforeach
                                                <td>-</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        @foreach($model->adminTableColumns() as $col)
                                            <th>{{ $col['name'] }}</th>
                                        @endforeach
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div><!-- /.row -->

    <!-- Modal -->
    <div class="modal modal-danger fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-target="#delete-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete confirm</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-target="#delete-modal" data-dismiss="modal">Close</button>
                    <form method="POST" action="" class="delete-form">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                        <input type="hidden" name="_method" value="DELETE" />

                        <button type="submit" type="button" class="delete-btn btn btn-outline">
                            Delete
                        </button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('additionalScripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-XSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });

        // Sortable
        /**
         * @param {*} requestData
         */
        var changePosition = function(requestData){

            $.ajax({
                'url': '/sort',
                'type': 'POST',
                'data': requestData,
                'success': function(data) {
                    if (data.success) {
                        // App.notify.success('Saved!');
                    } else {
                        // App.notify.validationError(data.errors);
                    }
                },
                'error': function(){
                    // App.notify.danger('Something wrong!');
                }
            });
        };

        var $sortableTable = $('.sortable');
        if ($sortableTable.length > 0) {
            $sortableTable.sortable({
                handle: '.sortable-handle',
                axis: 'y',
                update: function(a, b){

                    var entityName = $(this).data('entityname');
                    var $sorted = b.item;

                    var $previous = $sorted.prev();
                    var $next = $sorted.next();

                    if ($previous.length > 0) {
                        changePosition({
                            parentId: $sorted.data('parentid'),
                            type: 'moveAfter',
                            entityName: entityName,
                            id: $sorted.data('itemid'),
                            positionEntityId: $previous.data('itemid')
                        });
                    } else if ($next.length > 0) {
                        changePosition({
                            parentId: $sorted.data('parentid'),
                            type: 'moveBefore',
                            entityName: entityName,
                            id: $sorted.data('itemid'),
                            positionEntityId: $next.data('itemid')
                        });
                    } else {
                        App.notify.danger('Something wrong!');
                    }
                },
                cursor: "move"
            });
        }

        $('.sortable td').each(function(){
            $(this).css('width', $(this).width() +'px');
        });

        // Delete entity
        $('.js-open-delete-modal').on('click', function (e) {
            e.preventDefault();
            var that = $(this),
                $deleteModal = $('#delete-modal'),
                deleteURL = that.data('delete-url');

            $deleteModal.find('.delete-form').attr('action', deleteURL);

            $deleteModal.modal();
        });

        var isSortable = $('th.sort').length === 0;

        var table = $('#data-table').DataTable({
            "paging": isSortable !== false,
            "lengthChange": false,
            "searching": true,
            "ordering": isSortable !== false,
            "info": false,
            "autoWidth": false,
            columnDefs: [
                {
                    targets: "no-sort",
                    orderable: false,
                    searchable: false
                }
            ],
            "aaSorting": []
        });
    </script>
@stop
