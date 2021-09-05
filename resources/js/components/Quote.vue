<template>
    <div>
        <v-card
            elevation="4"
            class="mx-auto"
            max-width="1000"
            shaped
            tile
            style="margin-top:50px;"
        >
            <p
                class="text-center green mx-auto"
                style="width:250px; border-radius: 5px; margin-bottom:10px;"
            >
                Success
            </p>

            <p class="text-center">
                Total delivery weight:
                <b style="font-size:15px;">{{ quoteDetails.weight }}</b> <br />
                Total kilometres:
                <b style="font-size:15px;">{{ quoteDetails.kilometres }}</b>
                <br />
                Recommended mode of transport:
                <b style="font-size:15px;">{{ quoteDetails.type }}</b> <br />
                Travel cost:
                <b style="font-size:15px;">${{ quoteDetails.travelCost }}</b>
            </p>
        </v-card>
    </div>
</template>

<script>
export default {
    props: {
        quoteDetails: {
            type: Object,
            required: true
        }
    }
};
</script>
