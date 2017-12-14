<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#unreadmessages" role="tab"><span class="badge badge-pill badge-danger" style="font-size: 8px; display:block; float:right;">@{{ count }}</span><i class="fa fa-envelope-open-o" aria-hidden="true"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#readmessages" role="tab"><span class="badge badge-pill badge-success" style="font-size: 8px; display:block; float:right;"> @{{ archivedCount }}</span><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
    </li>
{{--  <li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#settings" role="tab"><i class="icon-settings"></i></a>
</li>  --}}
</ul>

<!-- Tab panes -->
<div class="tab-content">

    {{--  Unread Messages  --}}

    <div class="tab-pane active" id="unreadmessages" role="tabpanel">
        <div v-for="v,k in firstMessages">
            
        
            <div class="callout m-0 py-2 text-muted text-center bg-faded text-uppercase">
                <small><b>@{{ k }}</b></small>
            </div>

            <hr class="transparent mx-3 my-0">

            <div class="panel panel-default" v-for="ival, ikey in v">
                
                <div class="callout m-0 py-3" :class="ival.status_html">
                
                    <div class="card-header" >
                        <span class="badge badge-pill badge-danger" style="font-size: 10px; float:right;" v-if="ival.status==1">New</span>
                        <hr class="transparent mx-0 my-2">
                        <p data-toggle="collapse" data-parent="#accordion" :href="'#collapse'+ikey+'-main'" class="panel-title expand">
                            Subject: @{{ ival.subject }}
                            <br>
                            <small style="align:left">
                                @{{ ival.name }}
                            </small>
                            <small style="text-align:right; color:#777;">&nbsp; @{{ ival.created_at_formatted }}</small>
                        </p>
                    </div>
                    <div :id="'collapse'+ikey+'-main'" class="panel-collapse collapse" style="padding-top: 5px;">
                        <div class="panel-body">

                            <div>
                                <strong>Email:&nbsp;</strong>
                                <small>
                                    @{{ ival.email }}
                                </small>
                            </div>

                            <div>
                                <strong>Phone:&nbsp;</strong>
                                <small>
                                    @{{ ival.phone_formatted }}
                                </small>
                            </div>
                            <hr class="transparent mx-0 my-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <button type="button" data-toggle="collapse" data-parent="#accordion" :href="'#collapse-'+ikey" class="panel-title expand btn btn-secondary btn-block" @click="markAsRead(ival.id)" v-if="ival.status==1">
                                        Message
                                    </button>
                                    <button type="button" data-toggle="collapse" data-parent="#accordion" :href="'#collapse-'+ikey" class="panel-title expand btn btn-secondary btn-block" v-if="ival.status==2">
                                        Message
                                    </button>
                                </div>
                                <div :id="'collapse-'+ikey" class="panel-collapse collapse" style="padding-top: 5px;">
                                    <div class="panel-body">
                                        @{{ ival.message }}
                                    </div>
                                    <hr class="transparent mx-0 my-1">
                                    <div class="row">
                                        <div class="col-6" style="padding:2px;">
                                            <button type="button" class="btn btn-warning btn-small btn-block" @click="setAsArchive(ival.id)">Archive</button>
                                        </div>
                                        <div class="col-6" style="padding:2px;">
                                            <button type="button" class="btn btn-danger btn-small btn-block" @click="setAsDeleted(ival.id)">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>    
                <hr class="transparent mx-0 my-1">
      


            </div>
        </div>
    </div>

    {{--  Archive Section  --}}
    <div class="tab-pane p3" id="readmessages" role="tabpanel">
        <div v-for="v,k in secondMessages">
            
        
            <div class="callout m-0 py-2 text-muted text-center bg-faded text-uppercase">
                <small><b>@{{ k }}</b></small>
            </div>

            <hr class="transparent mx-3 my-0">

            <div class="panel panel-default" v-for="ival, ikey in v">
                
                <div class="callout callout-warning m-0 py-3">
                
                    <div class="card-header" >
                        <p data-toggle="collapse" data-parent="#accordion" :href="'#collapse'+ikey+'-archive'" class="panel-title expand">
                            Subject: @{{ ival.subject }}
                            <br>
                            <small style="align:left">
                                @{{ ival.name }}
                            </small>
                            <small style="text-align:right; color:#777;">&nbsp; @{{ ival.created_at_formatted }}</small>
                        </p>
                    </div>
                    <div :id="'collapse'+ikey+'-archive'" class="panel-collapse collapse" style="padding-top: 5px;">
                        <div class="panel-body">

                            <div>
                                <strong>Email:&nbsp;</strong>
                                <small>
                                    @{{ ival.email }}
                                </small>
                            </div>

                            <div>
                                <strong>Phone:&nbsp;</strong>
                                <small>
                                    @{{ ival.phone_formatted }}
                                </small>
                            </div>
                            <hr class="transparent mx-0 my-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <button type="button" data-toggle="collapse" data-parent="#accordion" :href="'#collapse-'+ikey+'-archiveread'" class="panel-title expand btn btn-secondary btn-block">
                                        Message
                                    </button>
                                </div>
                                <div :id="'collapse-'+ikey+'-archiveread'" class="panel-collapse collapse" style="padding-top: 5px;">
                                    <div class="panel-body">
                                        @{{ ival.message }}
                                    </div>
                                        <hr class="transparent mx-0 my-1">
                                        <div>
                                            <button type="button" class="btn btn-danger btn-small btn-block" @click="setAsDeleted(ival.id)">Delete</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>    
                <hr class="transparent mx-0 my-1">
            </div>
        </div>
    </div>