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

export default function Edit({ dataApi }) {
    const { data, setData, put, processing, errors } = useForm({
        nama: dataApi.nama || "", // Jika null, ganti string kosong biar gak error
        nidn: dataApi.nidn || "",
        no_hp: dataApi.no_hp || "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        // 4. Gunakan method PUT dan sertakan ID dosen
        put(route("dosen.update", dataApi.id));
    };
    return (
        <div>
            <form onSubmit={handleSubmit}>
                <FieldSet>
                    <FieldLegend>Edit Dosen</FieldLegend>
                    <FieldGroup>
                        <Field>
                            <FieldLabel htmlFor="name">nama</FieldLabel>
                            <Input
                                id="name"
                                autoComplete="off"
                                placeholder="Evil Rabbit"
                                value={data.nama}
                                onChange={(e) =>
                                    setData("nama", e.target.value)
                                }
                            />
                            {errors.nama && (
                                <FieldError>{errors.nama}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="nidn">nidn</FieldLabel>
                            <Input
                                id="nidn"
                                autoComplete="off"
                                aria-invalid
                                value={data.nidn}
                                onChange={(e) =>
                                    setData("nidn", e.target.value)
                                }
                            />
                            {errors.nidn && (
                                <FieldError>{errors.nidn}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="noHp">No. Hp</FieldLabel>
                            <Input
                                id="noHp"
                                autoComplete="off"
                                aria-invalid
                                value={data.no_hp}
                                onChange={(e) =>
                                    setData("no_hp", e.target.value)
                                }
                            />
                            {errors.no_hp && (
                                <FieldError>{errors.no_hp}</FieldError>
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
