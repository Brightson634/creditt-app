@php $i = 0; @endphp
@foreach ($members as $row)
    @php $i++; @endphp
    <tr>
        <th scope="row">{{ $i }}</th>
        <td><a
                href="{{ route('webmaster.member.dashboard', $row->member_no) }}">{{ $row->member_no }}</a>
        </td>
        <td>
            @if ($row->member_type == 'individual')
                {{ $row->title }} {{ $row->fname }}
                {{ $row->lname }}
            @endif
            @if ($row->member_type == 'group')
                {{ $row->fname }}
            @endif
        </td>
        <td>
            @if ($row->member_type == 'individual')
                MEMBER
            @endif
            @if ($row->member_type == 'group')
                GROUP
            @endif
        </td>
        <td>{{ $row->telephone }}</td>
        <td>{{ $row->email }}</td>
        <td>
            <a href="{{ route('webmaster.member.edit', $row->member_no) }}"
                class="btn btn-xs btn-dark"> <i class="far fa-edit"></i>
                Edit</a>
        </td>
    <tr>
@endforeach