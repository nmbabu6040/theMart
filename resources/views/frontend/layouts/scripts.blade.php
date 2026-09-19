 <!-- All JavaScript files
    ================================================== -->
 <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>

 {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
 <script>
     $(document).on('click', '.add-to-wishlist', function(e) {
         e.preventDefault();
         let productId = $(this).data('product-id');
         let button = $(this);

         $.ajax({
             url: "{{ route('wishlist.toggle') }}",
             type: "POST",
             data: {
                 _token: "{{ csrf_token() }}",
                 product_id: productId
             },
             success: function(response) {
                 if (response.status === 'success') {
                     alert(response.message);
                     // হেডার উইশলিস্ট কাউন্টার আপডেট (যদি থাকে)
                     $('.wishlist-count').text(response.count);
                 }
             },
             error: function(xhr) {
                 if (xhr.status === 401) {
                     alert('Please login first to manage your wishlist!');
                     window.location.href = "{{ route('login') }}";
                 } else {
                     alert('Something went wrong!');
                 }
             }
         });
     });
 </script>


 <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
 <!-- Plugins for this template -->
 <script src="{{ asset('frontend/assets/js/modernizr.custom.js') }}"></script>
 <script src="{{ asset('frontend/assets/js/jquery.dlmenu.js') }}"></script>
 <script src="{{ asset('frontend/assets/js/jquery-plugin-collection.js') }}"></script>
 <!-- Custom script for this template -->
 <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
 <script>
     $(document).ready(function() {
         // '+' বাটন ক্লিক করলে
         $('.qtybutton').on('click', function() {
             var $button = $(this);
             var $row = $button.closest('tr');
             var oldValue = $row.find('.text-value').val();
             var newVal = 0;

             if ($button.hasClass('inc')) {
                 newVal = parseFloat(oldValue) + 1;
             } else {
                 // মান ১ এর নিচে নামতে দেবে না
                 if (oldValue > 1) {
                     newVal = parseFloat(oldValue) - 1;
                 } else {
                     newVal = 1;
                 }
             }

             // ইনপুট ফিল্ডে নতুন পরিমাণ বসানো
             $row.find('.text-value').val(newVal);

             // প্রাইস এবং সাবটোটাল আপডেট করা
             updateSubtotal($row, newVal);
         });

         // সরাসরি ইনপুট বক্সে সংখ্যা টাইপ করলে
         $('.text-value').on('change keyup', function() {
             var $row = $(this).closest('tr');
             var qty = $(this).val();
             if (qty < 1 || isNaN(qty)) {
                 qty = 1;
                 $(this).val(1);
             }
             updateSubtotal($row, qty);
         });

         function updateSubtotal($row, qty) {
             // প্রাইস সেল থেকে দাম নেওয়া (মূল্য থেকে $ চিহ্ন বাদ দিয়ে)
             var priceText = $row.find('.unit-price').text().replace('$', '').trim();
             var unitPrice = parseFloat(priceText) || 0;

             // নতুন সাবটোটাল হিসাব
             var subtotal = unitPrice * qty;

             // সাবটোটাল কলামে নতুন মান দেখানো
             $row.find('.subtotal-price').text('$' + subtotal.toFixed(2));

             // গ্র্যান্ড টোটাল আপডেট করার ফাংশন
             updateGrandTotal();
         }

         function updateGrandTotal() {
             var grandTotal = 0;
             $('.subtotal-price').each(function() {
                 var val = parseFloat($(this).text().replace('$', '').trim()) || 0;
                 grandTotal += val;
             });

             // যদি আপনার পেজে Total Sum দেখানোর জায়গা থাকে (যেমন #grand-total id)
             $('#grand-total').text('$' + grandTotal.toFixed(2));
         }
     });
 </script>
 @stack('script')
