import axios from 'axios';

export enum TakedownStatus {
    PENDING,
    PROCESSING,
    ACCEPTED,
    REJECTED,
}

export interface ShortenedUrl {
    code: string
    destination?: string
    encrypted: boolean
    full_url: string
    created_at: string
}

export interface Takedown {
    'url_id': string
    'reason': string
    'status': TakedownStatus
}

export interface CutError {
    code: string
    message: string
}

class Services {
    static shortenUrl = (destination: string, passphrase?: string) => {
        return axios.post('shorten/short', { url: destination, passphrase: passphrase ?? null })
    }

    static unlockUrl = (code: string, passphrase: string) => {
        return axios.post('shorten/unlock', { code, passphrase })
    }

    static reportUrl = (code: string, reason: string, passphrase?: string) => {
        return axios.post('takedown/report', { code, reason, passphrase })
    }

    static listReports = () => {
        return axios.get(`takedown/list`)
    }
}

export default Services
