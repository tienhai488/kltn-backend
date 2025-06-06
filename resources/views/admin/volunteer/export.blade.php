<table>
    <thead>
        <tr>
            <th colspan="9" align="left" style="font-weight: bold; font-size: 20px; background-color: yellow;">Danh sách tình nguyện viên của {{ $project->name }}</th>
        </tr>
        <tr>
            <th align="left" style="font-weight: bold;">{{ __('STT') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Họ tên') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Email') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Số điện thoại') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Trạng thái') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Phòng ban') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Lớp') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('MSSV') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Ghi chú') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($volunteers as $index => $volunteer)
        <tr>
            <td align="left">{{ $index + 1 }}</td>
            <td align="left">{{ $volunteer['name'] ?? 'N/A' }}</td>
            <td align="left">{{ $volunteer['email'] ?? 'N/A' }}</td>
            <td align="left">{{ $volunteer['phone_number'] ?? 'N/A' }}</td>
            <td align="left" bgcolor="{{ $volunteer['status_label_for_export'] ?? '' }}">{{ $volunteer['status_label'] ?? 'N/A' }}</td>
            <td align="left">{{ $volunteer['department']?->name ?? 'N/A' }}</td>
            <td align="left">{{ $volunteer['class'] ?? 'N/A' }}</td>
            <td align="left">{{ $volunteer['student_code'] ?? 'N/A' }}</td>
            <td align="left">{{ $volunteer['note'] ?? 'N/A' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
