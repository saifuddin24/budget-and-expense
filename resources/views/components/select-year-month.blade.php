<select {{ $attributes->merge([ "class" => "px-2 py-0.5 text-sm border rounded-sm" ]) }}>
    <option value="">--ALL MONTH--</option>
    @foreach (range( date('Y')-3, date('Y') ) as $year )                
        <optgroup label="{{ $year }}">
            @foreach (range( 1, 12 ) as $month )                
                <option 
                    value="{{ $year }}-{{ $month }}" 
                    @selected( date('Y-n') == "{$year}-{$month}" )
                >
                    {{ 
                        \Illuminate\Support\Carbon::make("{$year}-{$month}")
                            ->format('F-Y')  
                    }}
                </option>
            @endforeach
        </optgroup>
    @endforeach
</select>