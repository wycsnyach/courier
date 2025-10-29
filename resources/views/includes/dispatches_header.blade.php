<div class="portlet-title tabbable-line">
    <ul class="nav nav-tabs" style="justify-content: flex-end; display: flex;">
         
        <li class="{{ Request::is('batches') ? 'active' : '' }}">
            <a href="{{ url('batches') }}" 
               style="background-color: {{ Request::is('batches') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('batches') ? '#fff' : '#000' }};">All Dispatches</a>
        </li>
        
        <li class="{{ Request::is('batch-dispatch') ? 'active' : '' }}">
            <a href="{{ url('batch-dispatch') }}" 
               style="background-color: {{ Request::is('batch-dispatch') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('batch-dispatch') ? '#fff' : '#000' }};">Dispatch</a>
        </li>
            
    </ul>
</div>