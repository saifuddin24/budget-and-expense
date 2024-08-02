<table class="w-full text-xs">
    <thead>
        <tr class="bg-gradient-to-b from-teal-50 to-teal-100 border-b">
            <th class="w-7/12 py-1.5">Title</th>
            <th class="w-3/12 py-1.5">Amount</th>
            <th class="w-2/12 py-1.5">Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($transactions as $index => $transaction)
            
            
            <tr class="border-b  border-dashed text-sm">
                <td rowspan="2" class="px-4 py-2 ">
                    <div class="line-clamp-2">
                        {{ $transaction->title }}
                    </div>
                    <div class="font-normal text-xs text-gray-500">
                        {{ strtoupper($transaction->created_at->format('d M Y h:i a')) }}
                    </div>
                </td>    

                @php
                    $bank_amount = $transaction->bank_credit_amount - $transaction->bank_debit_amount;   
                    $cash_amount = $transaction->cash_credit_amount - $transaction->cash_debit_amount;  
                    $status = $bank_amount + $cash_amount; 
                @endphp

                <td class="text-right px-4 pb-1 pt-2">
                    <div class="flex w-full">
                        <div class="w-3/6 text-left text-gray-400 text-sm">Cash:</div> 
                        <div class="w-3/6 text-right {{ $cash_amount < 0 ? 'text-red-500':'text-green-500' }}">
                            {{ number_format($cash_amount,2) }}
                        </div>
                    </div>
                </td> 
                
                <td rowspan="2" class="text-right px-4 py-2 font-semibold {{ $status < 0 ? 'text-red-500':'text-green-500' }}">
                    {{ $status }} BDT
                </td>    
            </tr>
            <tr class="border-b text-sm">
                <td class="text-right px-4 pb-1 pt-2">
                    <div class="flex w-full">
                        <div class="w-3/6 text-left text-gray-400 text-sm">Bank:</div> 
                        <div class="w-3/6 text-right {{ $bank_amount < 0 ? 'text-red-500':'text-green-500' }}">
                            {{ number_format($bank_amount,2) }}
                        </div>
                    </div>
                </td> 
            </tr>

        @endforeach
 

    </tbody>

</table>