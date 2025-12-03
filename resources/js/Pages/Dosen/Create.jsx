import { Button } from "@/Components/ui/button";
import {
    Field,
    FieldDescription,
    FieldError,
    FieldGroup,
    FieldLabel,
    FieldLegend,
    FieldSet,
} from "@/Components/ui/field";
import { Input } from "@/Components/ui/input";
import { Switch } from "@/Components/ui/switch";
import { useForm } from "@inertiajs/react";
import React from "react";

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        nama: "",
        nidn: "",
        no_hp: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("dosen.store"));
    };

    const resetSubmit = () => {
        setData({
            nama: "",
            no_hp: "",
            nidn: "",
        });
    };
    return (
        <div>
            <form onSubmit={handleSubmit}>
                <FieldSet>
                    <FieldLegend>Tambah Dosen</FieldLegend>
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
