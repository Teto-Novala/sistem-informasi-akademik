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
        nim: data.nim || "",
        nama: data.nama || "", // Jika null, ganti string kosong biar gak error
        jurusan: data.jurusan || "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        // 4. Gunakan method PUT dan sertakan ID dosen
        put(route("mahasiswa.update", data.id));
    };
    return (
        <div>
            <form onSubmit={handleSubmit}>
                <FieldSet>
                    <FieldLegend>Edit Mahasiswa</FieldLegend>
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
                            <FieldLabel htmlFor="nidn">nim</FieldLabel>
                            <Input
                                id="nidn"
                                autoComplete="off"
                                aria-invalid
                                value={dataApi.nim}
                                onChange={(e) =>
                                    setDataApi("nim", e.target.value)
                                }
                            />
                            {errors.nim && (
                                <FieldError>{errors.nim}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="noHp">Jurusan</FieldLabel>
                            <Input
                                id="noHp"
                                autoComplete="off"
                                aria-invalid
                                value={dataApi.jurusan}
                                onChange={(e) =>
                                    setDataApi("jurusan", e.target.value)
                                }
                            />
                            {errors.jurusan && (
                                <FieldError>{errors.jurusan}</FieldError>
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
