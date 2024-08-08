@props(['selected','yearMonths'])


@php
    
    if( !isset($yearMonths) ) {

        $yearMonths = collect(range( date('Y')-3, date('Y') ))->map(function($year){
            
            return [
                'year' => $year,
                'months' => range( 1, 12 ) 
            ];
        
        });
    }

@endphp

<select {{ $attributes->merge([ "class" => "px-2 py-0.5 text-sm border rounded-sm" ]) }}>
    <option value="">--ALL MONTH--</option>
    @foreach ($yearMonths as $year )                
        <optgroup label="{{ $year['year'] }}">
            @foreach ( $year['months'] as $month )                
                <option 
                    value="{{ $year['year'] }}-{{ str_pad($month,2,'0', STR_PAD_LEFT) }}" 
                    @selected( ($selected ?? date('Y-n')) == "{$year['year']}-{$month}" )
                >
                    {{ 
                        \Illuminate\Support\Carbon::make("{$year['year']}-{$month}")
                            ->format('F-Y')  
                    }}
                </option>
            @endforeach
        </optgroup>
    @endforeach
</select>