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

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        kode_mk: "",
        nama: "",
        sks: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("matakuliah.store"));
    };

    const resetSubmit = () => {
        setData({
            nama: "",
            kode_mk: "",
            sks: "",
        });
    };
    return (
        <div>
            <form onSubmit={handleSubmit}>
                <FieldSet>
                    <FieldLegend>Tambah Mata Kuliah</FieldLegend>
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
                            <FieldLabel htmlFor="nidn">Kode MK</FieldLabel>
                            <Input
                                id="nidn"
                                autoComplete="off"
                                aria-invalid
                                value={data.kode_mk}
                                onChange={(e) =>
                                    setData("kode_mk", e.target.value)
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
                                value={data.sks}
                                onChange={(e) => setData("sks", e.target.value)}
                            />
                            {errors.sks && (
                                <FieldError>{errors.sks}</FieldError>
                            )}
                        </Field>
                        <Button type="button" onClick={resetSubmit}>
                            Reset
                        </Button>
                        <Button type="submit">Tambah</Button>
                    </FieldGroup>
                </FieldSet>
            </form>
        </div>
    );
}
