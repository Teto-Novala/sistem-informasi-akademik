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
        nama: "",
        nim: "",
        jurusan: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("mahasiswa.store"));
    };

    const resetSubmit = () => {
        setData({
            nama: "",
            nim: "",
            jurusan: "",
        });
    };
    return (
        <div>
            <form onSubmit={handleSubmit}>
                <FieldSet>
                    <FieldLegend>Tambah Mahasiswa</FieldLegend>
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
                            <FieldLabel htmlFor="nidn">nim</FieldLabel>
                            <Input
                                id="nidn"
                                autoComplete="off"
                                aria-invalid
                                value={data.nim}
                                onChange={(e) => setData("nim", e.target.value)}
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
                                value={data.jurusan}
                                onChange={(e) =>
                                    setData("jurusan", e.target.value)
                                }
                            />
                            {errors.jurusan && (
                                <FieldError>{errors.no_hp}</FieldError>
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
