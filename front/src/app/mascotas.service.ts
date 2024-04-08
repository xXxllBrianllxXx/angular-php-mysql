import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Mascota } from "./mascota"
import { environment } from "../environments/environment"
@Injectable({
	providedIn: 'root'
})
export class MascotasService {

	baseUrl = environment.baseUrl

	constructor(private http: HttpClient) { }

	getMascotas() {
		return this.http.get(`${this.baseUrl}/api.php?module=pets`);
	}

	getMascota(id: string | number) {
		return this.http.get(`${this.baseUrl}/api.php?module=pets&id=${id}`);
	}

	addMascota(mascota: Mascota) {
		return this.http.post(`${this.baseUrl}/api.php?module=pets`, mascota);
	}

	deleteMascota(mascota: Mascota) {
		return this.http.delete(`${this.baseUrl}/api.php?module=pets&id=${mascota.id}`);
	}

	updateMascota(mascota: Mascota) {
		return this.http.put(`${this.baseUrl}/api.php?module=pets`, mascota);
	}
}
