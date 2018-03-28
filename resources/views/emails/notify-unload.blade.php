@component('mail::message')
# Scarico Materiale

@component('mail::panel')
- Utente  <strong>{{ $email['user'] }}</strong>
- Gruppo <strong>{{ $email['group'] }}</strong>
- Giorno <strong>{{ $email['date']}}</strong> alle <strong>{{ $email['time']  }}</strong>
@endcomponent

@component('mail::table')
| Code                     | Materiale                  | Qta                  |Um                       | Progetto                    | Deposito                   |
| :--                      |:---                        | -:                  | :-:                     | :-:                         | :-:                        |
| {{ $email['item_code'] }}| {{ $email['item_name'] }} | {{ $email['qta'] }} | {{ $email['item_um'] }} |{{ $email['project_name'] }} | {{ $email['depot_name'] }} |
@endcomponent

@if($email['project_id'])

@component('vendor.mail.html.button_2', [
'url1' => route('projects.show',$email['project_id']),
'color1' => 'green',
'url2' => route('depots.show', $email['depot_id'])
])
	@slot('link1')
		Progetto "{{ $email['project_name'] }}"
	@endslot
	
	@slot('link2')
		Deposito "{{ $email['depot_name'] }}"
	@endslot
@endcomponent

@else
	
	
@component('mail::button', ['url' => route('depots.show',$email['depot_id'])])
Progetto "{{ $email['depot_name'] }}"
@endcomponent
	
@endif

Thanks,<br>
{!! config('app.name') !!}
@endcomponent
