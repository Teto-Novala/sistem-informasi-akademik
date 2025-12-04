import { Button } from "@/Components/ui/button";
import {
    Field,
    FieldError,
    FieldGroup,
    FieldLabel,
    FieldLegend,
    FieldSet,
} from "@/Components/ui/field";
import { Input } from "@/Components/ui/input";
import { useForm } from "@inertiajs/react";
import React from "react";

export default function Edit({ data }) {
    const {
        data: dataApi,
        setData: setDataApi,
        put,
        processing,
        errors,
    } = useForm({
        kode_mk: data.kode_mk || "",
        nama: data.nama || "", // Jika null, ganti string kosong biar gak error
        sks: data.sks || "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        // 4. Gunakan method PUT dan sertakan ID dosen
        put(route("matakuliah.update", data.id));
    };
    return (
        <div>
            <form onSubmit={handleSubmit}>
                <FieldSet>
                    <FieldLegend>Edit Mata Kuliah</FieldLegend>
                    <FieldGroup>
                        <Field>
                            <FieldLabel htmlFor="name">nama</FieldLabel>
                            <Input
                                id="name"
                                autoComplete="off"
                                placeholder="Evil Rabbit"
                                value={dataApi.nama}
                                onChange={(e) =>
                                    setDataApi("nama", e.target.value)
                                }
                            />
                            {errors.nama && (
                                <FieldError>{errors.nama}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="nidn">
                                Kode Mata Kuliah
                            </FieldLabel>
                            <Input
                                id="nidn"
                                autoComplete="off"
                                aria-invalid
                                value={dataApi.kode_mk}
                                onChange={(e) =>
                                    setDataApi("kode_mk", e.target.value)
                                }
                            />
                            {errors.kode_mk && (
                                <FieldError>{errors.kode_mk}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="noHp">SKS</FieldLabel>
                            <Input
                                id="noHp"
                                autoComplete="off"
                                aria-invalid
                                value={dataApi.sks}
                                onChange={(e) =>
                                    setDataApi("sks", e.target.value)
                                }
                            />
                            {errors.sks && (
                                <FieldError>{errors.sks}</FieldError>
                            )}
                        </Field>
                        <Button
                            type="button"
                            onClick={() => window.history.back()}
                        >
                            kembali
                        </Button>
                        <Button type="submit">Edit</Button>
                    </FieldGroup>
                </FieldSet>
            </form>
        </div>
    );
}
