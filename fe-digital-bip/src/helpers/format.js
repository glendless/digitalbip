import numeral from "numeral";
import { DateTime } from "luxon";

// Format angka menjadi persen
export function formatPercentageValue(value) {
    return numeral(value).format("0,0.[00]%");
}

// Parse angka
export function parseRupiahValue(value) {
    return numeral(value).value();
}

// Format angka menjadi rupiah
export function formatRupiahValue(value) {
    return numeral(value).format("0,0.[00]");
}

// Format tanggal sederhana
export function formatDate(date) {
    const options = { day: "numeric", month: "long", year: "numeric" };
    return new Date(date).toLocaleDateString("id-ID", options);
}

// Format tanggal + waktu
export function formatDateTime(date) {
    const options = {
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
    };
    return new Date(date).toLocaleDateString("id-ID", options);
}

// Format tanggal dengan timezone Luxon
export function formatDateTimeWithTimezone(date) {
    const originDate = DateTime.fromISO(date, { zone: "utc" });
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    return originDate.setZone(timezone).toFormat("dd LLL yyyy, HH:mm");
}

// Ubah huruf pertama string jadi kapital
export function ucfirst(string) {
    return string ? string.charAt(0).toUpperCase() + string.slice(1) : "";
}
