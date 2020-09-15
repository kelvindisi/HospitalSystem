<template>
    <div
        class="modal fade"
        id="paymentModeModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="paymentModalLable"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLable">
                        Mode Of Payment
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    This is the body
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "PaymentModeComponent",
    props: ["patientId", "postTitle"],
    mounted: () => {
        console.log(postTitle);
    },
    data: function() {
        return {};
    }
};
</script>
