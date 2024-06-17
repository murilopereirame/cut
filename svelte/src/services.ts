import axios from 'axios';

export interface ShortenedUrl {
    code: string
    destination?: string
    encrypted: boolean
    full_url: string
    created_at: string
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
}

export default Services
