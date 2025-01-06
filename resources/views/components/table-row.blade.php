
<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-indigo-500">
    @foreach($rowData as $index=>$data)
        @if($index===0)
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <a href="{{route('show', $appointmentid)}}" class="block">
                    {{ Str::limit($data, 40) }}
                </a>
            </th>
        @else
            <td class="px-6 py-4">
                <a href="{{route('show', $appointmentid)}}" class="block">
                    {{ Str::limit($data, 40) }}
                </a>
            </td>
        @endif
    @endforeach
</tr>
