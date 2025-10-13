<div class="portlet-title tabbable-line">
    <ul class="nav nav-tabs" style="justify-content: flex-end; display: flex;">
         
        <li class="{{ Request::is('purchases') ? 'active' : '' }}">
            <a href="{{ url('purchases') }}" 
               style="background-color: {{ Request::is('purchases') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('purchases') ? '#fff' : '#000' }};">All Purchases</a>
        </li>
        
        <li class="{{ Request::is('purchases-search') ? 'active' : '' }}">
            <a href="{{ url('purchases-search') }}" 
               style="background-color: {{ Request::is('purchases-search') ? '#1AB394' : 'transparent' }}; color: {{ Request::is('purchases-search') ? '#fff' : '#000' }};">Purchase Reports</a>
        </li>


       
            
    </ul>
</div>