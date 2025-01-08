import.meta.glob([
    '../images/**',
]);
import './echo';

const orderIdElement = document.getElementById('order-id');
const orderRouteElement = document.getElementById('order-route');
const btnShowConfirmOrder = document.getElementById('btn-show-confirm-order')

if (orderIdElement && orderRouteElement) {
    Echo.private('order.' + orderIdElement.value)
        .listen('OrderCustomerChangeStatus', (e) => {
            console.log(e);
            window.location.replace(orderRouteElement.value);
        });
}

if (btnShowConfirmOrder) {
    Echo.private('zalo.sent.' + orderIdElement.value)
        .listen('ZaloSent', (e) => {
            console.log(e);
            btnShowConfirmOrder.click();
        });
}

window.addEventListener('DOMContentLoaded', function () {
    window.Echo.channel('attendances')
        .listen('SendAttendanceNotification', (event) => {
            console.log('test ', event);
            Livewire.dispatch('notification-changed');
        });
});
