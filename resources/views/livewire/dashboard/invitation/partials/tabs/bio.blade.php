@if ($category === 'Wedding' || $category === 'Engagement')
    @include('livewire.dashboard.invitation.partials.forms.wedding')
@elseif ($category === 'Birthday')
    @include('livewire.dashboard.invitation.partials.forms.birthday')
@elseif ($category === 'Aqiqah' || $category === 'Khitan')
    @include('livewire.dashboard.invitation.partials.forms.aqiqah')
@elseif ($category === 'Event')
    @include('livewire.dashboard.invitation.partials.forms.event')
@else
    @include('livewire.dashboard.invitation.partials.forms.general')
@endif
