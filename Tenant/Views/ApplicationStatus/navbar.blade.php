<?php $current = Request::segment(4); ?>
<div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="{{($current == '')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id")}}>Enquiry</a></li>
        <li class="{{($current == 'personal_details')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/personal_details")}}>Offer Letter Processing</a></li>
        <li class="{{($current == 'applications')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/applications")}}>Offer Letter Issued</a></li>
        <li class="{{($current == 'accounts')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/accounts")}}>Coe Processing</a></li>
        <li class="{{($current == 'document')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/document")}}>Coe Issued</a></li>
        <li class="{{($current == 'notes')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/notes")}}>Enrolled</a></li>
        <li class="{{($current == 'notes')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/notes")}}>Completed</a></li>
        <li class="{{($current == 'notes')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/notes")}}>Cancelled</a></li>
        <li class="{{($current == 'notes')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/notes")}}>Advance Search</a></li>
    </ul>
</div><!--/.nav-collapse -->