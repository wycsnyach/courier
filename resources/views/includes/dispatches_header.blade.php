<div class="portlet-title tabbable-line">
    <ul class="nav nav-tabs" style="justify-content: flex-end; display: flex;">
         
        <li class="{{ Request::is('batches') ? 'active' : '' }}">
            <a href="{{ url('batches') }}" 
               style="background-color: {{ Request::is('batches') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('batches') ? '#fff' : '#000' }};">Dispatches</a>
        </li>
        
        <li class="{{ Request::is('batch-dispatch') ? 'active' : '' }}">
            <a href="{{ url('batch-dispatch') }}" 
               style="background-color: {{ Request::is('batch-dispatch') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('batch-dispatch') ? '#fff' : '#000' }};">Dispatch</a>
        </li>
        <li class="{{ Request::is('all-batches') ? 'active' : '' }}">
            <a href="{{ url('all-batches') }}" 
               style="background-color: {{ Request::is('all-batches') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('all-batches') ? '#fff' : '#000' }};"> Dispatch Report</a>
        </li>

        <li class="{{ Request::is('batch-delivery') ? 'active' : '' }}">
            <a href="{{ url('batch-delivery') }}" 
               style="background-color: {{ Request::is('batch-delivery') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('batch-delivery') ? '#fff' : '#000' }};"> Delivery</a>
        </li>
        <li class="{{ Request::is('delivery-history') ? 'active' : '' }}">
            <a href="{{ url('delivery-history') }}" 
               style="background-color: {{ Request::is('delivery-history') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('delivery-history') ? '#fff' : '#000' }};"> Delivery History</a>
        </li>

        <li class="{{ Request::is('recipient-collection-list') ? 'active' : '' }}">
            <a href="{{ url('recipient-collection-list') }}" 
               style="background-color: {{ Request::is('recipient-collection-list') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('recipient-collection-list') ? '#fff' : '#000' }};"> Receive Parcel</a>
        </li>
            
    </ul>
</div>