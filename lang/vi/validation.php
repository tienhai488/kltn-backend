<?php

/*
|--------------------------------------------------------------------------
| Validation Language Lines
|--------------------------------------------------------------------------
|
| The following language lines contain the default error messages used by
| the validator class. Some of these rules have multiple versions such
| as the size rules. Feel free to tweak each of these messages here.
|
*/

return [
    'accepted'             => 'Trường :attribute phải được chấp nhận.',
    'active_url'           => 'Trường :attribute không phải là một URL hợp lệ.',
    'after'                => 'Trường :attribute phải là một ngày sau ngày :date.',
    'after_or_equal'       => 'Trường :attribute phải là thời gian bắt đầu sau hoặc đúng bằng :date.',
    'alpha'                => 'Trường :attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash'           => 'Trường :attribute chỉ có thể chứa chữ cái, số và dấu gạch ngang.',
    'alpha_num'            => 'Trường :attribute chỉ có thể chứa chữ cái và số.',
    'alpha_spaces'         => 'Trường :attribute chỉ có thể chứa chữ cái và dấu khoảng trắng.',
    'array'                => 'Trường :attribute phải là dạng mảng.',
    'attached'             => 'Trường :attribute đã được đính kèm.',
    'before'               => 'Trường :attribute phải là một ngày trước ngày :date.',
    'before_or_equal'      => 'Trường :attribute phải là thời gian bắt đầu trước hoặc đúng bằng :date.',
    'between'              => [
        'array'   => 'Trường :attribute phải có từ :min - :max phần tử.',
        'file'    => 'Dung lượng tập tin trong trường :attribute phải từ :min - :max kB.',
        'numeric' => 'Trường :attribute phải nằm trong khoảng :min - :max.',
        'string'  => 'Trường :attribute phải từ :min - :max kí tự.',
    ],
    'boolean'              => 'Trường :attribute phải là true hoặc false.',
    'confirmed'            => 'Giá trị xác nhận trong trường :attribute không khớp.',
    'current_password'     => 'Mật khẩu không đúng.',
    'date'                 => 'Trường :attribute không phải là định dạng của ngày-tháng.',
    'date_equals'          => 'Trường :attribute phải là một ngày bằng với :date.',
    'date_format'          => 'Trường :attribute không giống với định dạng :format.',
    'different'            => 'Trường :attribute và :other phải khác nhau.',
    'digits'               => 'Độ dài của trường :attribute phải gồm :digits chữ số.',
    'digits_between'       => 'Độ dài của trường :attribute phải nằm trong khoảng :min và :max chữ số.',
    'dimensions'           => 'Trường :attribute có kích thước không hợp lệ.',
    'distinct'             => 'Trường :attribute có giá trị trùng lặp.',
    'email'                => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'ends_with'            => 'Trường :attribute phải kết thúc bằng một trong những giá trị sau: :values',
    'exists'               => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'enum'                 => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'file'                 => 'Trường :attribute phải là một tệp tin.',
    'filled'               => 'Trường :attribute không được bỏ trống.',
    'gt'                   => [
        'array'   => 'Mảng :attribute phải có nhiều hơn :value phần tử.',
        'file'    => 'Dung lượng trường :attribute phải lớn hơn :value kilobytes.',
        'numeric' => 'Giá trị trường :attribute phải lớn hơn :value.',
        'string'  => 'Độ dài trường :attribute phải nhiều hơn :value kí tự.',
    ],
    'gte'                  => [
        'array'   => 'Mảng :attribute phải có ít nhất :value phần tử.',
        'file'    => 'Dung lượng trường :attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'numeric' => 'Giá trị trường :attribute phải lớn hơn hoặc bằng :value.',
        'string'  => 'Độ dài trường :attribute phải lớn hơn hoặc bằng :value kí tự.',
    ],
    'image'                => 'Trường :attribute phải là định dạng hình ảnh.',
    'in'                   => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'in_array'             => 'Trường :attribute phải thuộc tập cho phép: :other.',
    'integer'              => 'Trường :attribute phải là một số nguyên.',
    'ip'                   => 'Trường :attribute phải là một địa chỉ IP.',
    'ipv4'                 => 'Trường :attribute phải là một địa chỉ IPv4.',
    'ipv6'                 => 'Trường :attribute phải là một địa chỉ IPv6.',
    'json'                 => 'Trường :attribute phải là một chuỗi JSON.',
    'lt'                   => [
        'array'   => 'Mảng :attribute phải có ít hơn :value phần tử.',
        'file'    => 'Dung lượng trường :attribute phải nhỏ hơn :value kilobytes.',
        'numeric' => 'Giá trị trường :attribute phải nhỏ hơn :value.',
        'string'  => 'Độ dài trường :attribute phải nhỏ hơn :value kí tự.',
    ],
    'lte'                  => [
        'array'   => 'Mảng :attribute không được có nhiều hơn :value phần tử.',
        'file'    => 'Dung lượng trường :attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'numeric' => 'Giá trị trường :attribute phải nhỏ hơn hoặc bằng :value.',
        'string'  => 'Độ dài trường :attribute phải nhỏ hơn hoặc bằng :value kí tự.',
    ],
    'max'                  => [
        'array'   => 'Trường :attribute không được lớn hơn :max phần tử.',
        'file'    => 'Dung lượng tập tin trong trường :attribute không được lớn hơn :max kB.',
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'string'  => 'Trường :attribute không được lớn hơn :max kí tự.',
    ],
    'mimes'                => 'Trường :attribute phải là một tập tin có định dạng: :values.',
    'mimetypes'            => 'Trường :attribute phải là một tập tin có định dạng: :values.',
    'min'                  => [
        'array'   => 'Trường :attribute phải có tối thiểu :min phần tử.',
        'file'    => 'Dung lượng tập tin trong trường :attribute phải tối thiểu :min kB.',
        'numeric' => 'Trường :attribute phải tối thiểu là :min.',
        'string'  => 'Trường :attribute phải có tối thiểu :min kí tự.',
    ],
    'multiple_of'          => 'Trường :attribute phải là bội số của :value',
    'not_in'               => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'not_regex'            => 'Trường :attribute có định dạng không hợp lệ.',
    'no_scripts'           => 'Trường :attribute chứa thẻ script.',
    'numeric'              => 'Trường :attribute phải là một số.',
    'password'             => 'Mật khẩu không đúng.',
    'password'   => [
        'mixed' => 'Trường :attribute phải chứa ít nhất một chữ hoa và một chữ thường.',
        'letters' => 'Trường :attribute phải chứa ít nhất một chữ cái.',
        'symbols' => 'Trường :attribute phải chứa ít nhất một ký hiệu.',
        'numbers' => 'Trường :attribute phải chứa ít nhất một số.',
        'uncompromised' => 'Trường :attribute đã bị rò rỉ trước đó. Vui lòng chọn một :attribute khác.',
    ],
    'present'              => 'Trường :attribute phải được cung cấp.',
    'prohibited'           => 'Trường :attribute bị cấm.',
    'prohibited_if'        => 'Trường :attribute bị cấm khi :other là :value.',
    'prohibited_unless'    => 'Trường :attribute bị cấm trừ khi :other là một trong :values.',
    'regex'                => 'Trường :attribute có định dạng không hợp lệ.',
    'relatable'            => 'Trường :attribute không thể liên kết với tài nguyên này.',
    'required'             => 'Trường :attribute không được bỏ trống.',
    'required_if'          => 'Trường :attribute không được bỏ trống khi trường :other là :value.',
    'required_unless'      => 'Trường :attribute không được bỏ trống trừ khi :other là :values.',
    'required_with'        => 'Trường :attribute không được bỏ trống khi một trong :values có giá trị.',
    'required_with_all'    => 'Trường :attribute không được bỏ trống khi tất cả :values có giá trị.',
    'required_without'     => 'Trường :attribute không được bỏ trống khi một trong :values không có giá trị.',
    'required_without_all' => 'Trường :attribute không được bỏ trống khi tất cả :values không có giá trị.',
    'same'                 => 'Trường :attribute và :other phải giống nhau.',
    'size'                 => [
        'array'   => 'Trường :attribute phải chứa :size phần tử.',
        'file'    => 'Dung lượng tập tin trong trường :attribute phải bằng :size kB.',
        'numeric' => 'Trường :attribute phải bằng :size.',
        'string'  => 'Trường :attribute phải chứa :size kí tự.',
    ],
    'starts_with'          => 'Trường :attribute phải được bắt đầu bằng một trong những giá trị sau: :values',
    'string'               => 'Trường :attribute phải là một chuỗi kí tự.',
    'timezone'             => 'Trường :attribute phải là một múi giờ hợp lệ.',
    'unique'               => 'Trường :attribute đã có trong cơ sở dữ liệu.',
    'uploaded'             => 'Trường :attribute tải lên thất bại.',
    'url'                  => 'Trường :attribute không giống với định dạng một URL.',
    'uuid'                 => 'Trường :attribute phải là một chuỗi UUID hợp lệ.',
    'agree_ckb'            => 'Vui lòng đồng ý với những điều khoản của G-Lab.',
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    'attributes'           => [
        'address'               => 'địa chỉ',
        'age'                   => 'tuổi',
        'amount'                => 'lượng tiền',
        'available'             => 'có sẵn',
        'area_id'               => 'khu vực',
        'bank_name'             => 'tên ngân hàng',
        'bank_number'           => 'số tài khoản',
        'banner_desktop'        => 'banner cho website',
        'banner_category_id'    => 'danh mục banner',
        'body'                  => 'nội dung',
        'brand_id'              => 'thương hiệu',
        'brandId'               => 'thương hiệu',
        'categoryId'            => 'danh mục',
        'city'                  => 'thành phố',
        'code'                  => 'mã',
        'content'               => 'nội dung',
        'country'               => 'quốc gia',
        'date'                  => 'ngày',
        'day'                   => 'ngày',
        'description'           => 'mô tả',
        'email'                 => 'email',
        'export_method'         => 'phương thức xuất excel',
        'excerpt'               => 'trích dẫn',
        'first_name'            => 'tên',
        'file_name'             => 'tên tệp',
        'gender'                => 'giới tính',
        'hour'                  => 'giờ',
        'limit'                 => 'giới hạn',
        'identify_number'       => 'cccd',
        'image_cccd_back'       => 'hình ảnh cccd mặt sau',
        'image_cccd_front'      => 'hình ảnh cccd mặt trước',
        'item_categories'       => 'danh mục',
        'item_category_id'      => 'danh mục',
        'itemImages'            => 'hình ảnh sản phẩm',
        'itemName'              => 'tên sản phẩm',
        'item_person_type_id'   => 'đối tượng',
        'item_size_locale_id'   => 'kích cỡ',
        'item_stock_status_id'  => 'trạng thái tồn kho',
        'item_sizes'            => 'kích cỡ',
        'itemSku'               => 'sku',
        'last_name'             => 'họ',
        'message'               => 'lời nhắn',
        'minute'                => 'phút',
        'mobile'                => 'di động',
        'month'                 => 'tháng',
        'name'                  => 'tên',
        'password'              => 'mật khẩu',
        'password_confirmation' => 'xác nhận mật khẩu',
        'personTypeId'          => 'đối tượng',
        'phone'                 => 'số điện thoại',
        'province_id'           => 'tỉnh thành',
        'reason'                => 'lý do',
        'read_at'               => 'đọc tại',
        'second'                => 'giây',
        'sex'                   => 'giới tính',
        'selectedBoxConditionId' => 'tình trạng hộp',
        'selectedConditionId'   => 'tình trạng',
        'selectedItemId'        => 'sản phẩm',
        'size'                  => 'kích thước',
        'sizeId'                => 'kích thước',
        'status'                => 'trạng thái',
        'subject'               => 'tiêu đề',
        'time'                  => 'thời gian',
        'title'                 => 'tiêu đề',
        'type'                  => 'loại',
        'username'              => 'tên đăng nhập',
        'value'                 => 'giá trị',
        'year'                  => 'năm',
        'shipping_name'         => 'tên người nhận',
        'quote_id'              => 'giỏ hàng',
        'quantity'              => 'số lượng',
        'shipping_city_id'      => 'thành phố',
        'shipping_district_id'  => 'quận',
        'shipping_ward_id'      => 'phường',
        'shipping_phone'        => 'số điện thoại',
        'shipping_address'      => 'địa chỉ',
        'sale_price'            => 'giá bán',
        'payment_method_id'     => 'phương thức thanh toán',
        'total_price'           => 'tổng giá',
        'total_discount'        => 'tổng giảm giá',
        'times_to_receive_gift' => 'lượt giới hạn của thiết bị',
        'total'                 => 'thành tiền',
        'order_status_id'       => 'trạng thái đơn hàng',
        'order'                 => 'thứ tự',
        'paymentMethod'         => 'phương thức thanh toán',
        'price'                 => 'giá',
        'phone_number'          => 'số điện thoại',
        'offerPrice'            => 'giá',
        'city_id'               => 'thành phố',
        'client_id'             => 'khách hàng',
        'district_id'           => 'quận',
        'ward_id'               => 'phường',
        'name.vi'               => 'tên vi',
        'name.en'               => 'tên en',
        'roles'                 => 'vai trò',
        'permissions'           => 'quyền được truy cập',
        'user_avatar'           => 'ảnh đại diện',
        'current_password'      => 'mật khẩu hiện tại',
        'detail_address'        => 'mô tả chi tiết',
        'google_map_link'       => 'đường dẫn bản đồ',
        'target_revenue'        => 'KPI',
        'start_date'            => 'ngày bắt đầu',
        'end_date'              => 'ngày kết thúc',
        'exchange_rules.*.name' => 'tên scheme',
        'exchange_rules.*.description' => 'mô tả scheme',
        'exchange_rules.*.products.*.product_id' => 'tên sản phẩm',
        'exchange_rules.*.products.*.product_min_id' => 'tên sản phẩm',
        'exchange_rules.*.products.*.product_quantity' => 'số lượng sản phẩm',
        'exchange_rules.*.gifts.*.gift_id' => 'tên quà tặng',
        'exchange_rules.*.gifts.*.gift_quantity' => 'số lượng quà tặng',
        'exchange_rules.*.product_ids' => 'sản phẩm',
        'exchange_rules.*.product_min_ids' => 'sản phẩm',
        'exchange_rules.*.min_target_price' => 'giá tiền tối thiểu',
        'exchange_rules.*.min_target_price_small' => 'giá tiền tối thiểu',
        'exchange_rules.*.type' => 'loại scheme',
        'address_id'            => 'địa chỉ',
        'address_note'          => 'chi tiết địa chỉ',
        'address_name'          => 'tên địa chỉ',
        'longitude'             => 'kinh độ',
        'latitude'              => 'vĩ độ',
        'checkin_time'          => 'thời gian bắt đầu',
        'checkout_time'         => 'thời gian kết thúc',
        'supervisor_id'         => 'supervisor',
        'supervisor_ids'        => 'supervisor',
        'admin_ids'             => 'quản trị viên',
        'member_ids'            => 'PB/PG',
        'zalo_app_id'           => 'mã ứng dụng',
        'zalo_access_token'     => 'mã truy cập',
        'zalo_refresh_token'    => 'mã làm mới',
        'campaign_id'           => 'chiến dịch',
        'campaign_name'         => 'tên chiến dịch',
        'run_time'              => 'ngày chạy',
        'user_id'               => 'người tạo',
        'birth_of_date'         => 'ngày tháng năm sinh',
        'category_id'           => 'danh mục',
        'donation_target'       => 'số tiền quyên góp',
        'volunteer_quantity'    => 'số lượng tình nguyện viên',
        'note'                  => 'ghi chú',
    ],

];