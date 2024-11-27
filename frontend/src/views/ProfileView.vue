<template>
    <div>
        <Profile v-if="userType === 'Candidate'" />
        <ProfileRecruiter v-else-if="userType === 'Recruiter'" />
    </div>
</template>

<script>
import ProfileRecruiter from '@/components/ProfileRecruiter.vue';
import Profile from '../components/Profile.vue';
import { mapGetters } from 'vuex';

export default {
    components: {
        Profile,
        ProfileRecruiter,
    },
    computed: {
        ...mapGetters(["getUser"]),
        userType() {
            return this.getUser?.type === "recruiter" ? "Recruiter" : "Candidate";
        },
    },
};
</script>
