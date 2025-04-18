<table>
    <thead>
        <tr>
            <th colspan="10" align="center" style="font-weight: bold; font-size: 20px; background-color: yellow;">Danh sách quyên góp của {{ !empty($donations[0]) ? $donations[0]['project']['name'] : '' }}</th>
        </tr>
        <tr>
            <th align="left" style="font-weight: bold;">{{ __('STT') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Tên tài khoản') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Số tài khoản') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Email') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Số điện thoại') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Phòng ban') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Lớp') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('MSSV') }}</th>
            <th align="right" style="font-weight: bold;">{{ __('Số tiền') }}</th>
            <th align="left" style="font-weight: bold;">{{ __('Thời gian') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($donations as $index => $donation)
        <tr>
            <td align="left">{{ $index + 1 }}</td>
            <td align="left">{{ $donation['account_name'] }}</td>
            <td align="left">{{ $donation['account_number'] }}</td>
            <td align="left">{{ $donation['email'] ?? 'N/A' }}</td>
            <td align="left">{{ $donation['phone_number'] ?? 'N/A' }}</td>
            <td align="left">{{ $donation['department']?->name ?? 'N/A' }}</td>
            <td align="left">{{ $donation['class'] ?? 'N/A' }}</td>
            <td align="left">{{ $donation['student_code'] ?? 'N/A' }}</td>
            <td align="right">{{ $donation['amount'] }}</td>
            <td align="left">{{ $donation['created_at'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
